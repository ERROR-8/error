import java.util.*;

class RoomInfo {
    int number;
    String category;
    boolean available;

    RoomInfo(int number, String category) {
        this.number = number;
        this.category = category;
        this.available = true;
    }
}

class Booking {
    ArrayList<RoomInfo> list = new ArrayList<>();

    void addRoom(int no, String cat) {
        list.add(new RoomInfo(no, cat));
        System.out.println("Room added successfully!");
    }

    void showAllRooms() {
        System.out.println("\n--- Room List ---");
        if (list.isEmpty()) {
            System.out.println("No rooms available!");
        } else {
            for (RoomInfo r : list) {
                System.out.println("Room " + r.number + " (" + r.category + ") - " + 
                    (r.available ? "Available" : "Booked"));
            }
        }
    }

    void bookRoom(int no) {
        for (RoomInfo r : list) {
            if (r.number == no && r.available) {
                r.available = false;
                System.out.println("Room " + no + " has been booked!");
                return;
            }
        }
        System.out.println("Room not found or already booked!");
    }

    void cancelBooking(int no) {
        for (RoomInfo r : list) {
            if (r.number == no && !r.available) {
                r.available = true;
                System.out.println("Booking cancelled for Room " + no);
                return;
            }
        }
        System.out.println("Room not booked yet!");
    }
}

public class HotelApp {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        Booking b = new Booking();

        // Add some demo rooms
        b.addRoom(101, "Single");
        b.addRoom(102, "Double");
        b.addRoom(201, "Suite");

        int ch;
        do {
            System.out.println("\n==== Hotel Menu ====");
            System.out.println("1. Show Rooms");
            System.out.println("2. Book Room");
            System.out.println("3. Cancel Booking");
            System.out.println("4. Exit");
            System.out.print("Enter choice: ");
            ch = sc.nextInt();

            switch (ch) {
                case 1:
                    b.showAllRooms();
                    break;
                case 2:
                    System.out.print("Enter room number to book: ");
                    int rn = sc.nextInt();
                    b.bookRoom(rn);
                    break;
                case 3:
                    System.out.print("Enter room number to cancel: ");
                    int cn = sc.nextInt();
                    b.cancelBooking(cn);
                    break;
                case 4:
                    System.out.println("System closed. Goodbye!");
                    break;
                default:
                    System.out.println("Invalid choice! Try again.");
            }
        } while (ch != 4);

        sc.close();
    }
}
