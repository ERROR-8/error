import java.util.*;

class BookInfo {
    String bookTitle;
    boolean taken;

    BookInfo(String bookTitle) {
        this.bookTitle = bookTitle;
        this.taken = false;
    }
}

class User {
    String userName;

    User(String userName) {
        this.userName = userName;
    }
}

class LibrarySystem {
    ArrayList<BookInfo> list = new ArrayList<>();

    void insertBook(String title) {
        list.add(new BookInfo(title));
    }

    void showAllBooks() {
        System.out.println("\nBooks currently available:");
        for (BookInfo b : list) {
            if (!b.taken) {
                System.out.println("- " + b.bookTitle);
            }
        }
    }

    void borrowBook(String title, User u) {
        for (BookInfo b : list) {
            if (b.bookTitle.equalsIgnoreCase(title) && !b.taken) {
                b.taken = true;
                System.out.println(u.userName + " borrowed \"" + title + "\"");
                return;
            }
        }
        System.out.println("Sorry, that book is not available right now.");
    }

    void giveBackBook(String title, User u) {
        for (BookInfo b : list) {
            if (b.bookTitle.equalsIgnoreCase(title) && b.taken) {
                b.taken = false;
                System.out.println(u.userName + " returned \"" + title + "\"");
                return;
            }
        }
        System.out.println("That book wasn’t issued or doesn’t exist.");
    }
}

public class LibraryMain {
    public static void main(String[] args) {
        Scanner input = new Scanner(System.in);
        LibrarySystem lib = new LibrarySystem();

        // Adding some books
        lib.insertBook("Java Basics");
        lib.insertBook("C Programming");
        lib.insertBook("Data Structures");

        System.out.print("Enter your name: ");
        String name = input.nextLine();
        User u = new User(name);

        int option;
        do {
            System.out.println("\n=== Library Menu ===");
            System.out.println("1. View Books");
            System.out.println("2. Borrow Book");
            System.out.println("3. Return Book");
            System.out.println("4. Exit");
            System.out.print("Choose option: ");
            option = input.nextInt();
            input.nextLine(); // clear buffer

            switch (option) {
                case 1:
                    lib.showAllBooks();
                    break;
                case 2:
                    System.out.print("Enter book name to borrow: ");
                    String borrowTitle = input.nextLine();
                    lib.borrowBook(borrowTitle, u);
                    break;
                case 3:
                    System.out.print("Enter book name to return: ");
                    String returnTitle = input.nextLine();
                    lib.giveBackBook(returnTitle, u);
                    break;
                case 4:
                    System.out.println("Exiting... Have a nice day!");
                    break;
                default:
                    System.out.println("Invalid option! Try again.");
            }
        } while (option != 4);

        input.close();
    }
}
