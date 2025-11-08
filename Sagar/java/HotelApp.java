import java.util.*;

class Room {
    int number;
    boolean free;

    Room(int number) {
        this.number = number;
        this.free = true;
    }
}

class Hotel {
    ArrayList<Room> rooms = new ArrayList<>();

    void addRoom(int number) {
        rooms.add(new Room(number));
    }

    void showRooms() {
        System.out.println("\n--- Room Status ---");
        for (Room r : rooms) {
            System.out.println("Room " + r.number + " - " + (r.free ? "Available" : "Booked"));
        }
    }

    void book(int number) {
        for (Room r : rooms) {
            if (r.number == number) {
                if (r.free) {
                    r.free = false;
                    System.out.println("Room " + number + " booked successfully!");
                } else {
                    System.out.println("Room already booked!");
                }
                return;
            }
        }
        System.out.println("Room not found!");
    }

    void cancel(int number) {
        for (Room r : rooms) {
            if (r.number == number) {
                if (!r.free) {
                    r.free = true;
                    System.out.println("Booking cancelled for Room " + number);
                } else {
                    System.out.println("Room is not booked!");
                }
                return;
            }
        }
        System.out.println("Room not found!");
    }
}

public class HotelApp {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        Hotel h = new Hotel();

        // Adding some rooms
        h.addRoom(101);
        h.addRoom(102);
        h.addRoom(103);

        int ch;
        do {
            System.out.println("\n=== Hotel Booking System ===");
            System.out.println("1. Show Rooms");
            System.out.println("2. Book Room");
            System.out.println("3. Cancel Booking");
            System.out.println("4. Exit");
            System.out.print("Enter your choice: ");
            ch = sc.nextInt();

            switch (ch) {
                case 1:
                    h.showRooms();
                    break;
                case 2:
                    System.out.print("Enter room number to book: ");
                    int bookNo = sc.nextInt();
                    h.book(bookNo);
                    break;
                case 3:
                    System.out.print("Enter room number to cancel: ");
                    int cancelNo = sc.nextInt();
                    h.cancel(cancelNo);
                    break;
                case 4:
                    System.out.println("Thank you for visiting!");
                    break;
                default:
                    System.out.println("Invalid choice!");
            }
        } while (ch != 4);

        sc.close();
    }
}
