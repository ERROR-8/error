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
        rooms.put(roomNumber, new Room(roomNumber));
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

public class SimpleHotel {
    public static void main(String[] args) {
        Hotel hotel = new Hotel();
        hotel.addRoom(101);
        hotel.addRoom(102);
        hotel.addRoom(103);
        hotel.addRoom(201);

        try (Scanner sc = new Scanner(System.in)) {
            int choice;
            do {
                System.out.println("\n=== Hotel Booking System ===");
                System.out.println("1. Show All Rooms");
                System.out.println("2. Book a Room");
                System.out.println("3. Cancel a Booking");
                System.out.println("4. Exit");
                System.out.print("Enter choice: ");
                choice = sc.nextInt();

                switch (choice) {
                    case 1:
                        hotel.showAllRooms();
                        break;
                    case 2:
                        System.out.print("Enter room number to book: ");
                        int bookNum = sc.nextInt();
                        hotel.bookRoom(bookNum);
                        break;
                    case 3:
                        System.out.print("Enter room number to cancel: ");
                        int cancelNum = sc.nextInt();
                        hotel.cancelBooking(cancelNum);
                        break;
                    case 4:
                        System.out.println("Thank you for using our system!");
                        break;
                    default:
                        System.out.println("Invalid choice! Please try again.");
                }
            } while (choice != 4);
        } catch (InputMismatchException e) {
            System.err.println("Invalid input. Please enter a valid number.");
        }
    }
}
