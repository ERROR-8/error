import java.util.*;

public class SimpleHotel {
    static class Room {
        int no;
        boolean free;

        Room(int no) {
            this.no = no;
            this.free = true;
        }
    }

    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        ArrayList<Room> rooms = new ArrayList<>();

        // Adding sample rooms
        rooms.add(new Room(101));
        rooms.add(new Room(102));
        rooms.add(new Room(103));

        int ch;
        do {
            System.out.println("\n=== Hotel Booking System ===");
            System.out.println("1. Show Rooms");
            System.out.println("2. Book Room");
            System.out.println("3. Cancel Booking");
            System.out.println("4. Exit");
            System.out.print("Enter choice: ");
            ch = sc.nextInt();

            if (ch == 1) {
                System.out.println("\n--- Room List ---");
                for (Room r : rooms)
                    System.out.println("Room " + r.no + " - " + (r.free ? "Available" : "Booked"));
            } 
            else if (ch == 2) {
                System.out.print("Enter room number: ");
                int num = sc.nextInt();
                boolean found = false;
                for (Room r : rooms) {
                    if (r.no == num) {
                        found = true;
                        if (r.free) {
                            r.free = false;
                            System.out.println("Room " + num + " booked successfully!");
                        } else {
                            System.out.println("Room is already booked!");
                        }
                        break;
                    }
                }
                if (!found) System.out.println("Room not found!");
            } 
            else if (ch == 3) {
                System.out.print("Enter room number: ");
                int num = sc.nextInt();
                boolean found = false;
                for (Room r : rooms) {
                    if (r.no == num) {
                        found = true;
                        if (!r.free) {
                            r.free = true;
                            System.out.println("Booking cancelled for Room " + num);
                        } else {
                            System.out.println("Room is not booked!");
                        }
                        break;
                    }
                }
                if (!found) System.out.println("Room not found!");
            } 
            else if (ch == 4) {
                System.out.println("Thank you for using our system!");
            } 
            else {
                System.out.println("Invalid choice!");
            }
        } while (ch != 4);

        sc.close();
    }
}
