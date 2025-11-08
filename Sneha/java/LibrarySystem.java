import java.util.*;

class Book {
    String title;
    boolean issued;

    Book(String title) {
        this.title = title;
        this.issued = false;
    }
}

class Library {
    ArrayList<Book> books = new ArrayList<>();

    void addBook(String title) {
        books.add(new Book(title));
        System.out.println("Book added: " + title);
    }

    void showBooks() {
        System.out.println("\n--- Book List ---");
        for (Book b : books) {
            System.out.println(b.title + (b.issued ? " (Issued)" : " (Available)"));
        }
    }

    void issueBook(String title) {
        for (Book b : books) {
            if (b.title.equalsIgnoreCase(title) && !b.issued) {
                b.issued = true;
                System.out.println("Book issued: " + title);
                return;
            }
        }
        System.out.println("Book not available!");
    }

    void returnBook(String title) {
        for (Book b : books) {
            if (b.title.equalsIgnoreCase(title) && b.issued) {
                b.issued = false;
                System.out.println("Book returned: " + title);
                return;
            }
        }
        System.out.println("Invalid return or not issued!");
    }
}

public class LibrarySystem {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        Library lib = new Library();

        lib.addBook("Java Programming");
        lib.addBook("Python Basics");
        lib.addBook("C++ Fundamentals");

        int ch;
        do {
            System.out.println("\n=== Library Menu ===");
            System.out.println("1. Show Books");
            System.out.println("2. Issue Book");
            System.out.println("3. Return Book");
            System.out.println("4. Exit");
            System.out.print("Enter your choice: ");
            ch = sc.nextInt();
            sc.nextLine(); // clear buffer

            switch (ch) {
                case 1:
                    lib.showBooks();
                    break;
                case 2:
                    System.out.print("Enter book title to issue: ");
                    String issueTitle = sc.nextLine();
                    lib.issueBook(issueTitle);
                    break;
                case 3:
                    System.out.print("Enter book title to return: ");
                    String returnTitle = sc.nextLine();
                    lib.returnBook(returnTitle);
                    break;
                case 4:
                    System.out.println("Thank you! Visit again.");
                    break;
                default:
                    System.out.println("Invalid choice!");
            }
        } while (ch != 4);

        sc.close();
    }
}
