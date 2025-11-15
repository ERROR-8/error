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

enum BookingStatus { SUCCESS, NOT_FOUND, ALREADY_BOOKED }
enum CancellationStatus { SUCCESS, NOT_FOUND, NOT_BOOKED }

class Hotel {
    private final Map<Integer, Room> rooms = new TreeMap<>(); // TreeMap keeps rooms sorted by number

    public boolean addRoom(int roomNumber) {
        if (rooms.containsKey(roomNumber)) {
            return false; // Indicate failure
        }
        rooms.put(roomNumber, new Room(roomNumber));
        return true; // Indicate success
    }

    public Collection<Room> getRooms() {
        return rooms.values();
    }

    public BookingStatus bookRoom(int roomNumber) {
        Room room = rooms.get(roomNumber);
        if (room == null) {
            return BookingStatus.NOT_FOUND;
        }
        if (room.book()) {
            return BookingStatus.SUCCESS;
        }
        return BookingStatus.ALREADY_BOOKED;
    }

    public CancellationStatus cancelBooking(int roomNumber) {
        Room room = rooms.get(roomNumber);
        if (room == null) {
            return CancellationStatus.NOT_FOUND;
        }
        if (room.vacate()) {
            return CancellationStatus.SUCCESS;
        }
        return CancellationStatus.NOT_BOOKED;
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
                    printRoomStatus();
                    break;
                case 2:
                    processBooking();
                    break;
                case 3:
                    processCancellation();
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

    private void printRoomStatus() {
        System.out.println("\n--- Room Status ---");
        Collection<Room> rooms = hotel.getRooms();
        if (rooms.isEmpty()) {
            System.out.println("No rooms in the hotel.");
            return;
        }
        for (Room room : rooms) {
            System.out.println(room);
        }
    }

    private void processBooking() {
        System.out.print("Enter room number to book: ");
        int bookNum = scanner.nextInt();
        BookingStatus status = hotel.bookRoom(bookNum);
        switch (status) {
            case SUCCESS:
                System.out.println("Room " + bookNum + " booked successfully!");
                break;
            case NOT_FOUND:
                System.out.println("Error: Room " + bookNum + " does not exist.");
                break;
            case ALREADY_BOOKED:
                System.out.println("Sorry, Room " + bookNum + " is already booked.");
                break;
        }
    }

    private void processCancellation() {
        System.out.print("Enter room number to cancel: ");
        int cancelNum = scanner.nextInt();
        CancellationStatus status = hotel.cancelBooking(cancelNum);
        switch (status) {
            case SUCCESS:
                System.out.println("Booking for Room " + cancelNum + " has been cancelled.");
                break;
            case NOT_FOUND:
                System.out.println("Error: Room " + cancelNum + " does not exist.");
                break;
            case NOT_BOOKED:
                System.out.println("Error: Room " + cancelNum + " was not booked.");
                break;
        }
    }
}

public class SimpleHotel {
    public static void main(String[] args) {
        Hotel hotel = new Hotel();
        System.out.println("Initializing hotel...");
        addInitialRooms(hotel);

        try (Scanner sc = new Scanner(System.in)) {
            HotelService service = new HotelService(hotel, sc);
            service.run();
        } catch (InputMismatchException e) {
            System.err.println("Invalid input. Please enter a valid number.");
        }
    }

    private static void addInitialRooms(Hotel hotel) {
        int[] roomNumbers = {101, 102, 103, 201};
        for (int roomNumber : roomNumbers) {
            if (hotel.addRoom(roomNumber)) {
                System.out.println("Room " + roomNumber + " added to the hotel.");
            }
        }
    }
}
