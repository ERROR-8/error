import java.util.*;

public class HotelSystem {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        int[] rooms = {101, 102, 103};
        boolean[] free = {true, true, true};

        int ch;
        do {
            System.out.println("\n=== Simple Hotel Booking ===");
            System.out.println("1. Show Rooms");
            System.out.println("2. Book Room");
            System.out.println("3. Cancel Booking");
            System.out.println("4. Exit");
            System.out.print("Enter choice: ");
            ch = sc.nextInt();

            if (ch == 1) {
                System.out.println("\n--- Room List ---");
                for (int i = 0; i < rooms.length; i++) {
                    System.out.println("Room " + rooms[i] + " - " + (free[i] ? "Available" : "Booked"));
                }
            } 
            else if (ch == 2) {
                System.out.print("Enter room number: ");
                int r = sc.nextInt();
                boolean found = false;
                for (int i = 0; i < rooms.length; i++) {
                    if (rooms[i] == r) {
                        found = true;
                        if (free[i]) {
                            free[i] = false;
                            System.out.println("Room " + r + " booked successfully!");
                        } else {
                            System.out.println("Room already booked!");
                        }
                    }
                }
                if (!found) System.out.println("Room not found!");
            } 
            else if (ch == 3) {
                System.out.print("Enter room number: ");
                int r = sc.nextInt();
                boolean found = false;
                for (int i = 0; i < rooms.length; i++) {
                    if (rooms[i] == r) {
                        found = true;
                        if (!free[i]) {
                            free[i] = true;
                            System.out.println("Booking cancelled for Room " + r);
                        } else {
                            System.out.println("Room is not booked!");
                        }
                    }
                }
                if (!found) System.out.println("Room not found!");
            } 
            else if (ch == 4) {
                System.out.println("Thank you for visiting!");
            } 
            else {
                System.out.println("Invalid choice!");
            }
        } while (ch != 4);

        sc.close();
    }
}
