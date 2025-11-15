import java.util.*;

class Room {
    private final int roomNumber;
    private boolean isAvailable;

    public Room(int roomNumber) {
        this.roomNumber = roomNumber;
        this.isAvailable = true;
    }

    public int getRoomNumber() {
        return roomNumber;
    }

    public boolean isAvailable() {
        return isAvailable;
    }

    public boolean book() {
        if (isAvailable) {
            isAvailable = false;
            return true; // Booking successful
        }
        return false; // Already booked
    }

    public boolean vacate() {
        if (!isAvailable) {
            isAvailable = true;
            return true; // Cancellation successful
        }
        return false; // Was not booked
    }

    @Override
    public String toString() {
        return "Room " + roomNumber + " - " + (isAvailable ? "Available" : "Booked");
    }
}

class Hotel {
    private final Map<Integer, Room> rooms = new TreeMap<>(); // TreeMap keeps rooms sorted by number

    public void addRoom(int roomNumber) {
        if (rooms.containsKey(roomNumber)) {
            System.out.println("Error: Room " + roomNumber + " already exists.");
            return;
        }
        rooms.put(roomNumber, new Room(roomNumber));
        System.out.println("Room " + roomNumber + " added to the hotel.");
    }

    public void showAllRooms() {
        System.out.println("\n--- Room Status ---");
        if (rooms.isEmpty()) {
            System.out.println("No rooms in the hotel.");
            return;
        }
        for (Room room : rooms.values()) {
            System.out.println(room);
        }
    }

    public void bookRoom(int roomNumber) {
        Room room = rooms.get(roomNumber);
        if (room == null) {
            System.out.println("Error: Room " + roomNumber + " does not exist.");
        } else if (room.book()) {
            System.out.println("Room " + roomNumber + " booked successfully!");
        } else {
            System.out.println("Sorry, Room " + roomNumber + " is already booked.");
        }
    }

    public void cancelBooking(int roomNumber) {
        Room room = rooms.get(roomNumber);
        if (room == null) {
            System.out.println("Error: Room " + roomNumber + " does not exist.");
        } else if (room.vacate()) {
            System.out.println("Booking for Room " + roomNumber + " has been cancelled.");
        } else {
            System.out.println("Error: Room " + roomNumber + " was not booked.");
        }
    }
}

class HotelService {
    private final Hotel hotel;
    private final Scanner scanner;

    public HotelService(Hotel hotel, Scanner scanner) {
        this.hotel = hotel;
        this.scanner = scanner;
    }

    public void run() {
        int choice;
        do {
            printMenu();
            choice = scanner.nextInt();

            switch (choice) {
                case 1:
                    hotel.showAllRooms();
                    break;
                case 2:
                    System.out.print("Enter room number to book: ");
                    int bookNum = scanner.nextInt();
                    hotel.bookRoom(bookNum);
                    break;
                case 3:
                    System.out.print("Enter room number to cancel: ");
                    int cancelNum = scanner.nextInt();
                    hotel.cancelBooking(cancelNum);
                    break;
                case 4:
                    System.out.println("Thank you for using our system!");
                    break;
                default:
                    System.out.println("Invalid choice! Please try again.");
            }
        } while (choice != 4);
    }

    private void printMenu() {
        System.out.println("\n=== Hotel Booking System ===");
        System.out.println("1. Show All Rooms");
        System.out.println("2. Book a Room");
        System.out.println("3. Cancel a Booking");
        System.out.println("4. Exit");
        System.out.print("Enter choice: ");
    }
}

public class SimpleHotel {
    public static void main(String[] args) {
        Hotel hotel = new Hotel();
        System.out.println("Initializing hotel...");
        hotel.addRoom(101);
        hotel.addRoom(102);
        hotel.addRoom(103);
        hotel.addRoom(201);

        try (Scanner sc = new Scanner(System.in)) {
            HotelService service = new HotelService(hotel, sc);
            service.run();
        } catch (InputMismatchException e) {
            System.err.println("Invalid input. Please enter a valid number.");
        }
    }
}
