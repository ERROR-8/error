import java.util.*;

/**
 * Represents a single book in the library.
 * This class encapsulates the book's data, making fields private
 * and providing public methods (getters/setters) to access them.
 */
class Book {
    private final String name;
    private boolean isIssued;

    public Book(String name) {
        this.name = name;
        this.isIssued = false;
    }

    public String getName() {
        return name;
    }

    public boolean isIssued() {
        return isIssued;
    }

    public void setIssued(boolean issued) {
        isIssued = issued;
    }

    @Override
    public String toString() {
        return name + (isIssued ? " (Issued)" : " (Available)");
    }
}

/**
 * Manages the collection of books and library operations.
 * Uses a Map for efficient book lookup by name (O(1) average time complexity).
 * A TreeMap is used to keep the books sorted alphabetically by name.
 */
class Library {
    // Using a Map for efficient lookups. Key is the book name (lowercase for case-insensitivity).
    private final Map<String, Book> books = new TreeMap<>();

    void addBook(String name) {
        // The key is stored in lowercase to make searches case-insensitive.
        books.put(name.toLowerCase(), new Book(name));
        System.out.println("Book added successfully: " + name);
    }

    void showAll() {
        System.out.println("\n--- Available Books ---");
        if (books.isEmpty()) {
            System.out.println("The library has no books.");
            return;
        }
        for (Book book : books.values()) {
            System.out.println(book);
        }
    }

    boolean issueBook(String name) {
        Book book = books.get(name.toLowerCase());
        if (book != null && !book.isIssued()) {
            book.setIssued(true);
            return true;
        }
        return false;
    }

    boolean returnBook(String name) {
        Book book = books.get(name.toLowerCase());
        if (book != null && book.isIssued()) {
            book.setIssued(false);
            return true;
        }
        return false;
    }
}

public class LibraryApp {
    public static void main(String[] args) {
        // Use try-with-resources to ensure the scanner is closed automatically.
        try (Scanner scanner = new Scanner(System.in)) {
            Library library = new Library();

            // Sample books
            library.addBook("Core Java");
            library.addBook("HTML Basics");
            library.addBook("Python Guide");

            int choice = 0;
            while (choice != 4) {
                System.out.println("\n=== Library Menu ===");
                System.out.println("1. Show All Books");
                System.out.println("2. Issue Book");
                System.out.println("3. Return Book");
                System.out.println("4. Exit");
                System.out.print("Enter your choice: ");

                try {
                    choice = scanner.nextInt();
                } catch (InputMismatchException e) {
                    System.out.println("Invalid input. Please enter a number.");
                    scanner.next(); // Clear the invalid input
                    continue; // Skip the rest of the loop
                }
                scanner.nextLine(); // Consume the rest of the line

                switch (choice) {
                    case 1:
                        library.showAll();
                        break;
                    case 2:
                        System.out.print("Enter book name to issue: ");
                        String bookToIssue = scanner.nextLine();
                        if (library.issueBook(bookToIssue)) {
                            System.out.println("Book issued successfully: " + bookToIssue);
                        } else {
                            System.out.println("Sorry, this book is not available for issue.");
                        }
                        break;
                    case 3:
                        System.out.print("Enter book name to return: ");
                        String bookToReturn = scanner.nextLine();
                        if (library.returnBook(bookToReturn)) {
                            System.out.println("Book returned successfully: " + bookToReturn);
                        } else {
                            System.out.println("Invalid return. Book not found or was not issued.");
                        }
                        break;
                    case 4:
                        System.out.println("Thank you for using the Library!");
                        break;
                    default:
                        System.out.println("Invalid choice! Please enter a number between 1 and 4.");
                }
            }
        }
    }
}
