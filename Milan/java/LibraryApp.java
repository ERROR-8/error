import java.util.*;

class BookData {
    String name;
    boolean isIssued;

    BookData(String name) {
        this.name = name;
        this.isIssued = false;
    }
}

class LibraryStore {
    ArrayList<BookData> bookList = new ArrayList<>();

    void addBook(String name) {
        bookList.add(new BookData(name));
        System.out.println("Book added successfully: " + name);
    }

    void showAll() {
        System.out.println("\n--- Available Books ---");
        for (BookData b : bookList) {
            System.out.println(b.name + (b.isIssued ? " (Issued)" : " (Available)"));
        }
    }

    void issueBook(String name) {
        for (BookData b : bookList) {
            if (b.name.equalsIgnoreCase(name) && !b.isIssued) {
                b.isIssued = true;
                System.out.println("Book issued successfully: " + name);
                return;
            }
        }
        System.out.println("Book not available for issue!");
    }

    void returnBook(String name) {
        for (BookData b : bookList) {
            if (b.name.equalsIgnoreCase(name) && b.isIssued) {
                b.isIssued = false;
                System.out.println("Book returned successfully: " + name);
                return;
            }
        }
        System.out.println("Book not found or not issued!");
    }
}

public class LibraryApp {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        LibraryStore lib = new LibraryStore();

        // Sample books
        lib.addBook("Core Java");
        lib.addBook("HTML Basics");
        lib.addBook("Python Guide");

        int ch;
        do {
            System.out.println("\n=== Library Menu ===");
            System.out.println("1. Show All Books");
            System.out.println("2. Issue Book");
            System.out.println("3. Return Book");
            System.out.println("4. Exit");
            System.out.print("Enter your choice: ");
            ch = sc.nextInt();
            sc.nextLine(); // clear buffer

            switch (ch) {
                case 1:
                    lib.showAll();
                    break;
                case 2:
                    System.out.print("Enter book name to issue: ");
                    String issue = sc.nextLine();
                    lib.issueBook(issue);
                    break;
                case 3:
                    System.out.print("Enter book name to return: ");
                    String ret = sc.nextLine();
                    lib.returnBook(ret);
                    break;
                case 4:
                    System.out.println("Thank you for using the Library!");
                    break;
                default:
                    System.out.println("Invalid choice!");
            }
        } while (ch != 4);

        sc.close();
    }
}
