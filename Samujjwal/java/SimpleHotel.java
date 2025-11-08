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

    void addRoom(int roomNo, String type) {
        rooms.add(new Room(roomNo, type));
    }

    void showRooms() {
        System.out.println("\n--- Room List ---");
        for (Room r : rooms) {
            System.out.println("Room " + r.roomNo + " (" + r.type + ") - " +
                    (r.isFree ? "Available" : "Booked"));
        }
    }

    void bookRoom(int roomNo) {
        for (Room r : rooms) {
            if (r.roomNo == roomNo && r.isFree) {
                r.isFree = false;
                System.out.println("Room " + roomNo + " booked successfully!");
                return;
            }
        }
        System.out.println("Room not available!");
    }

    void cancelRoom(int roomNo) {
        for (Room r : rooms) {
            if (r.roomNo == roomNo && !r.isFree) {
                r.isFree = true;
                System.out.println("Booking cancelled for Room " + roomNo);
                return;
            }
        }
        System.out.println("Room is not booked!");
    }
}

public class SimpleHotel {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        Hotel h = new Hotel();

        // Adding some sample rooms
        h.addRoom(101, "Single");
        h.addRoom(102, "Double");
        h.addRoom(201, "Suite");

        int ch;
        do {
            System.out.println("\n=== Hotel Menu ===");
            System.out.println("1. Show Rooms");
            System.out.println("2. Book Room");
            System.out.println("3. Cancel Room");
            System.out.println("4. Exit");
            System.out.print("Enter choice: ");
            ch = sc.nextInt();

            switch (ch) {
                case 1:
                    h.showRooms();
                    break;
                case 2:
                    System.out.print("Enter room number to book: ");
                    int rno = sc.nextInt();
                    h.bookRoom(rno);
                    break;
                case 3:
                    System.out.print("Enter room number to cancel: ");
                    int cno = sc.nextInt();
                    h.cancelRoom(cno);
                    break;
                case 4:
                    System.out.println("Thank you! Visit again!");
                    break;
                default:
                    System.out.println("Invalid choice!");
            }
        } while (ch != 4);

        sc.close();
    }
}
