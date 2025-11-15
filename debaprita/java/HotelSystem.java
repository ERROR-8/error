import java.util.*;

class Room {
    private final int roomNumber;
    private final String type;
    private boolean isAvailable;

    public Room(int roomNumber, String type) {
        this.roomNumber = roomNumber;
        this.type = type;
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
            return true;
        }
        return false;
    }

    public boolean vacate() {
        if (!isAvailable) {
            isAvailable = true;
            return true;
        }
        return false;
    }

    @Override
    public String toString() {
        return String.format("Room No: %-5d | Type: %-10s | Status: %s",
                roomNumber, type, (isAvailable ? "Available" : "Booked"));
    }
}

class Hotel {
    private final Map<Integer, Room> rooms = new TreeMap<>(); // TreeMap keeps rooms sorted by number

    public boolean addRoom(int roomNumber, String type) {
        if (rooms.containsKey(roomNumber)) {
            return false; // Room already exists
        }
        rooms.put(roomNumber, new Room(roomNumber, type));
        return true;
    }

    public void displayRooms() {
        System.out.println("\n--- Room Details ---");
        if (rooms.isEmpty()) {
            System.out.println("No rooms have been added to the hotel yet.");
        } else {
            rooms.values().forEach(System.out::println);
        }
    }

    public boolean bookRoom(int roomNumber) {
        Room room = rooms.get(roomNumber);
        if (room != null) {
            return room.book();
        }
        return false; // Room not found
    }

    public boolean cancelBooking(int roomNumber) {
        Room room = rooms.get(roomNumber);
        if (room != null) {
            return room.vacate();
        }
        return false; // Room not found
    }
}

public class HotelSystem {
    public static void main(String[] args) {
        try (Scanner sc = new Scanner(System.in)) {
            Hotel hotel = new Hotel();

            // Add some sample rooms
            hotel.addRoom(101, "Single");
            hotel.addRoom(102, "Double");
            hotel.addRoom(103, "Suite");

            int choice;
            do {
                System.out.println("\n==== Hotel Menu ====");
                System.out.println("1. Show Rooms");
                System.out.println("2. Book Room");
                System.out.println("3. Cancel Booking");
                System.out.println("4. Exit");
                System.out.print("Enter your choice: ");
                choice = sc.nextInt();

                switch (choice) {
                    case 1:
                        hotel.displayRooms();
                        break;
                    case 2:
                        System.out.print("Enter room number to book: ");
                        int bookNum = sc.nextInt();
                        if (hotel.bookRoom(bookNum)) {
                            System.out.println("Room " + bookNum + " booked successfully!");
                        } else {
                            System.out.println("Room not available, already booked, or does not exist!");
                        }
                        break;
                    case 3:
                        System.out.print("Enter room number to cancel: ");
                        int cancelNum = sc.nextInt();
                        if (hotel.cancelBooking(cancelNum)) {
                            System.out.println("Booking cancelled for Room " + cancelNum);
                        } else {
                            System.out.println("Room not found or was not booked!");
                        }
                        break;
                    case 4:
                        System.out.println("Thank you for using Hotel System!");
                        break;
                    default:
                        System.out.println("Invalid choice!");
                }
            } while (choice != 4);

        } catch (InputMismatchException e) {
            System.err.println("Invalid input. Please enter a valid number.");
        }
    }
}
