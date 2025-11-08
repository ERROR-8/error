import java.util.*;

class BookRecord {
    String name;
    boolean issued;

    BookRecord(String name) {
        this.name = name;
        this.issued = false;
    }
}

class UserData {
    String uname;

    UserData(String uname) {
        this.uname = uname;
    }
}

class ReadingHub {
    ArrayList<BookRecord> stock = new ArrayList<>();

    void addNew(String n) {
        stock.add(new BookRecord(n));
    }

    void listBooks() {
        System.out.println("\nBooks Available:");
        for (BookRecord b : stock) {
            if (!b.issued) {
                System.out.println("- " + b.name);
            }
        }
    }

    void issue(String n, UserData u) {
        for (BookRecord b : stock) {
            if (b.name.equalsIgnoreCase(n) && !b.issued) {
                b.issued = true;
                System.out.println(u.uname + " has taken \"" + n + "\".");
                return;
            }
        }
        System.out.println("Book not found or already issued.");
    }

    void takeBack(String n, UserData u) {
        for (BookRecord b : stock) {
            if (b.name.equalsIgnoreCase(n) && b.issued) {
                b.issued = false;
                System.out.println(u.uname + " has returned \"" + n + "\".");
                return;
            }
        }
        System.out.println("This book was not issued to anyone.");
    }
}

public class BookCorner {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        ReadingHub hub = new ReadingHub();

        hub.addNew("Java Basics");
        hub.addNew("Python for Starters");
        hub.addNew("Database Concepts");

        System.out.print("Enter your name: ");
        String user = sc.nextLine();
        UserData u = new UserData(user);

        int ch;
        do {
            System.out.println("\n==== Book Corner ====");
            System.out.println("1. Show All Books");
            System.out.println("2. Issue Book");
            System.out.println("3. Return Book");
            System.out.println("4. Exit");
            System.out.print("Enter choice: ");
            ch = sc.nextInt();
            sc.nextLine();

            switch (ch) {
                case 1:
                    hub.listBooks();
                    break;
                case 2:
                    System.out.print("Enter book name to issue: ");
                    String bn = sc.nextLine();
                    hub.issue(bn, u);
                    break;
                case 3:
                    System.out.print("Enter book name to return: ");
                    String rn = sc.nextLine();
                    hub.takeBack(rn, u);
                    break;
                case 4:
                    System.out.println("Goodbye " + user + "! Have a great day!");
                    break;
                default:
                    System.out.println("Invalid input, try again!");
            }
        } while (ch != 4);

        sc.close();
    }
}
