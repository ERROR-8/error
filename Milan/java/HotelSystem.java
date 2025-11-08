import java.util.*;

class Room {
    int roomNo;
    String type;
    boolean isFree;

    Room(int roomNo, String type) {
        this.roomNo = roomNo;
        this.type = type;
        this.isFree = true;
    }
}

class Hotel {
    ArrayList<Room> rooms = new ArrayList<>();

    void addRoom(int no, String type) {
        rooms.add(new Room(no, type));
        System.out.println("Room added successfully!");
    }

    void showRooms() {
        System.out.println("\n--- Room Details ---");
        for (Room r : rooms) {
            System.out.println("Room No: " + r.roomNo + " | Type: " + r.type + 
                " | Status: " + (r.isFree ? "Available" : "Booked"));
        }
    }

    void bookRoom(int no) {
        for (Room r : rooms) {
            if (r.roomNo == no && r.isFree) {
                r.isFree = false;
                System.out.println("Room " + no + " booked successfully!");
                return;
            }
        }
        System.out.println("Room not available or already booked!");
    }

    void cancelRoom(int no) {
        for (Room r : rooms) {
            if (r.roomNo == no && !r.isFree) {
                r.isFree = true;
                System.out.println("Booking cancelled for Room " + no);
                return;
            }
        }
        System.out.println("Room not found or not booked!");
    }
}

public class HotelSystem {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        Hotel h = new Hotel();

        // Add some sample rooms
        h.addRoom(101, "Single");
        h.addRoom(102, "Double");
        h.addRoom(103, "Suite");

        int ch;
        do {
            System.out.println("\n==== Hotel Menu ====");
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
                    int bn = sc.nextInt();
                    h.bookRoom(bn);
                    break;
                case 3:
                    System.out.print("Enter room number to cancel: ");
                    int cn = sc.nextInt();
                    h.cancelRoom(cn);
                    break;
                case 4:
                    System.out.println("Thank you for using Hotel System!");
                    break;
                default:
                    System.out.println("Invalid choice!");
            }
        } while (ch != 4);

        sc.close();
    }
}
