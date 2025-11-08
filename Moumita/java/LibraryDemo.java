import java.util.*;

class BookData {
    String title;
    boolean isBorrowed;

    BookData(String title) {
        this.title = title;
        this.isBorrowed = false;
    }
}

class Person {
    String fullName;

    Person(String fullName) {
        this.fullName = fullName;
    }
}

class BookStore {
    ArrayList<BookData> collection = new ArrayList<>();

    void addNewBook(String t) {
        collection.add(new BookData(t));
    }

    void showAvailableBooks() {
        System.out.println("\nBooks you can borrow:");
        for (BookData b : collection) {
            if (!b.isBorrowed) {
                System.out.println("- " + b.title);
            }
        }
    }

    void takeBook(String t, Person p) {
        for (BookData b : collection) {
            if (b.title.equalsIgnoreCase(t) && !b.isBorrowed) {
                b.isBorrowed = true;
                System.out.println(p.fullName + " took \"" + t + "\" from library.");
                return;
            }
        }
        System.out.println("Book not found or already borrowed!");
    }

    void bringBackBook(String t, Person p) {
        for (BookData b : collection) {
            if (b.title.equalsIgnoreCase(t) && b.isBorrowed) {
                b.isBorrowed = false;
                System.out.println(p.fullName + " returned \"" + t + "\" to library.");
                return;
            }
        }
        System.out.println("Book not found or not borrowed!");
    }
}

public class LibraryDemo {
    public static void main(String[] args) {
        Scanner scan = new Scanner(System.in);
        BookStore lib = new BookStore();

        // Add some books
        lib.addNewBook("Learn Java");
        lib.addNewBook("HTML Basics");
        lib.addNewBook("Operating System");

        System.out.print("Enter your name: ");
        String user = scan.nextLine();
        Person p = new Person(user);

        int choice;
        do {
            System.out.println("\n----- MENU -----");
            System.out.println("1. View Books");
            System.out.println("2. Take Book");
            System.out.println("3. Return Book");
            System.out.println("4. Exit");
            System.out.print("Enter option: ");
            choice = scan.nextInt();
            scan.nextLine();

            switch (choice) {
                case 1:
                    lib.showAvailableBooks();
                    break;
                case 2:
                    System.out.print("Enter book name to take: ");
                    String t1 = scan.nextLine();
                    lib.takeBook(t1, p);
                    break;
                case 3:
                    System.out.print("Enter book name to return: ");
                    String t2 = scan.nextLine();
                    lib.bringBackBook(t2, p);
                    break;
                case 4:
                    System.out.println("Thank you! Visit again soon.");
                    break;
                default:
                    System.out.println("Wrong option, try again!");
            }
        } while (choice != 4);

        scan.close();
    }
}
