import java.util.*;

class Room {
    int number;
    String type;
    boolean available;

    Room(int number, String type) {
        this.number = number;
        this.type = type;
        this.available = true;
    }
}

class Reservation {
    int roomNo;
    String guest;

    Reservation(int roomNo, String guest) {
        this.roomNo = roomNo;
        this.guest = guest;
    }
}

class Hotel {
    ArrayList<Room> rooms = new ArrayList<>();
    ArrayList<Reservation> bookings = new ArrayList<>();

    void addRoom(int number, String type) {
        rooms.add(new Room(number, type));
    }

    void showRooms() {
        System.out.println("\n--- Room List ---");
        for (Room r : rooms) {
            System.out.println("Room " + r.number + " (" + r.type + ") - " +
                    (r.available ? "Available" : "Booked"));
        }
    }

    void bookRoom(int number, String guest) {
        for (Room r : rooms) {
            if (r.number == number && r.available) {
                r.available = false;
                bookings.add(new Reservation(number, guest));
                System.out.println("Room booked successfully!");
                return;
            }
        }
        System.out.println("Room not available!");
    }

    void cancelBooking(int number) {
        for (Room r : rooms) {
            if (r.number == number && !r.available) {
                r.available = true;
                System.out.println("Booking cancelled!");
                return;
            }
        }
        System.out.println("Room is not booked!");
    }

    void showBookings() {
        System.out.println("\n--- Booking Details ---");
        if (bookings.isEmpty()) {
            System.out.println("No bookings yet.");
        } else {
            for (Reservation b : bookings) {
                System.out.println("Room: " + b.roomNo + " | Guest: " + b.guest);
            }
        }
    }
}

public class HotelBooking {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        Hotel h = new Hotel();

        // adding some sample rooms
        h.addRoom(101, "Single");
        h.addRoom(102, "Double");
        h.addRoom(201, "Suite");

        int ch;
        do {
            System.out.println("\n=== Hotel Menu ===");
            System.out.println("1. Show Rooms");
            System.out.println("2. Book Room");
            System.out.println("3. Cancel Booking");
            System.out.println("4. Show Bookings");
            System.out.println("5. Exit");
            System.out.print("Enter your choice: ");
            ch = sc.nextInt();
            sc.nextLine();

            switch (ch) {
                case 1:
                    h.showRooms();
                    break;
                case 2:
                    System.out.print("Enter room number: ");
                    int num = sc.nextInt();
                    sc.nextLine();
                    System.out.print("Enter guest name: ");
                    String g = sc.nextLine();
                    h.bookRoom(num, g);
                    break;
                case 3:
                    System.out.print("Enter room number to cancel: ");
                    int n = sc.nextInt();
                    h.cancelBooking(n);
                    break;
                case 4:
                    h.showBookings();
                    break;
                case 5:
                    System.out.println("Thank you for using Hotel System!");
                    break;
                default:
                    System.out.println("Invalid option!");
            }
        } while (ch != 5);

        sc.close();
    }
}
