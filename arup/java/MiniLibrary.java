import java.util.*;

class Book {
    private final String bookName;
    private Member borrowedBy;

    Book(String bookName) {
        this.bookName = bookName;
        this.borrowedBy = null; // Initially not borrowed
    }

    public String getBookName() {
        return bookName;
    }

    public Member getBorrowedBy() {
        return borrowedBy;
    }

    public boolean isAvailable() {
        return borrowedBy == null;
    }

    void borrow(Member member) {
        this.borrowedBy = member;
    }

    void returnBook() {
        this.borrowedBy = null;
    }
}

class Member {
    private final String name;

    Member(String name) {
        this.name = name;
    }

    public String getName() {
        return name;
    }
}

enum BorrowStatus { SUCCESS, BOOK_NOT_FOUND, ALREADY_BORROWED }
enum ReturnStatus { SUCCESS, BOOK_NOT_FOUND, NOT_BORROWED, BORROWED_BY_ANOTHER }

class Library {
    // Using a Map for efficient O(1) lookup by book title.
    // LinkedHashMap maintains insertion order for predictable display.
    private final Map<String, Book> books = new LinkedHashMap<>();

    boolean addBook(String name) {
        // Use lowercase for the key to make lookups case-insensitive.
        if (books.containsKey(name.toLowerCase())) {
            return false; // Indicate failure (book already exists)
        }
        books.put(name.toLowerCase(), new Book(name));
        return true; // Indicate success
    }

    void viewBooks() {
        System.out.println("\nAvailable Books:");
        long availableCount = books.values().stream()
                .filter(Book::isAvailable)
                .map(Book::getBookName)
                .peek(bookName -> System.out.println("- " + bookName))
                .count();

        if (availableCount == 0) {
            System.out.println("No books are currently available.");
        }
    }

    BorrowStatus borrowBook(String bookName, Member member) {
        Book book = books.get(bookName.toLowerCase());
        if (book == null) {
            return BorrowStatus.BOOK_NOT_FOUND;
        }
        if (!book.isAvailable()) {
            return BorrowStatus.ALREADY_BORROWED;
        }
        book.borrow(member);
        return BorrowStatus.SUCCESS;
    }

    ReturnStatus returnBook(String bookName, Member member) {
        Book book = books.get(bookName.toLowerCase());
        if (book == null) {
            return ReturnStatus.BOOK_NOT_FOUND;
        }
        if (book.isAvailable()) {
            return ReturnStatus.NOT_BORROWED;
        }
        if (book.getBorrowedBy() != member) {
            return ReturnStatus.BORROWED_BY_ANOTHER;
        }
        book.returnBook();
        return ReturnStatus.SUCCESS;
    }
}

class LibraryService {
    private final Library library;
    private final Member member;
    private final Scanner scanner;

    public LibraryService(Library library, Member member, Scanner scanner) {
        this.library = library;
        this.member = member;
        this.scanner = scanner;
    }

    public void run() {
        try {
            int option;
            do {
                System.out.println("\n==== Library Menu ====");
                System.out.println("1. View Available Books");
                System.out.println("2. Borrow a Book");
                System.out.println("3. Return a Book");
                System.out.println("4. Exit");
                System.out.print("Enter your choice: ");
                option = scanner.nextInt();
                scanner.nextLine(); // Consume the newline character

                switch (option) {
                    case 1:
                        library.viewBooks();
                        break;
                    case 2:
                        processBorrow();
                        break;
                    case 3:
                        processReturn();
                        break;
                    case 4:
                        System.out.println("Thank you for using the library!");
                        break;
                    default:
                        System.out.println("Invalid option! Please try again.");
                }
            } while (option != 4);
        } catch (InputMismatchException e) {
            System.err.println("Invalid input. Please enter a number for the menu choice.");
            scanner.nextLine(); // Clear the invalid input
        }
    }

    private void processBorrow() {
        System.out.print("Enter book name to borrow: ");
        String borrowName = scanner.nextLine();
        BorrowStatus status = library.borrowBook(borrowName, member);
        switch (status) {
            case SUCCESS:
                System.out.println(member.getName() + " borrowed \"" + borrowName + "\" successfully.");
                break;
            case BOOK_NOT_FOUND:
                System.out.println("Sorry, a book with the title \"" + borrowName + "\" does not exist in our library.");
                break;
            case ALREADY_BORROWED:
                System.out.println("Sorry, \"" + borrowName + "\" is currently borrowed.");
                break;
        }
    }

    private void processReturn() {
        System.out.print("Enter book name to return: ");
        String returnName = scanner.nextLine();
        ReturnStatus status = library.returnBook(returnName, member);
        switch (status) {
            case SUCCESS:
                System.out.println(member.getName() + " returned \"" + returnName + "\" successfully.");
                break;
            case BOOK_NOT_FOUND:
                System.out.println("Error: A book with the title \"" + returnName + "\" does not exist in our system.");
                break;
            case NOT_BORROWED:
                System.out.println("Error: \"" + returnName + "\" was not borrowed.");
                break;
            case BORROWED_BY_ANOTHER:
                System.out.println("Error: This book was borrowed by someone else, not you.");
                break;
        }
    }
}

public class MiniLibrary {
    public static void main(String[] args) {
        Library library = new Library();
        library.addBook("Java Made Easy");
        library.addBook("C Programming");
        library.addBook("Computer Networks");

        try (Scanner sc = new Scanner(System.in)) {
            System.out.print("Enter your name to become a library member: ");
            String userName = sc.nextLine();
            Member member = new Member(userName);
            System.out.println("Welcome, " + member.getName() + "!");

            LibraryService service = new LibraryService(library, member, sc);
            service.run();
        }
    }
}
