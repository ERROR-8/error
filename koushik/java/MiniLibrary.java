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

class Library {
    // Using a Map for efficient O(1) lookup by book title.
    // LinkedHashMap maintains insertion order for predictable display.
    private final Map<String, Book> books = new LinkedHashMap<>();

    void addBook(String name) {
        // Use lowercase for the key to make lookups case-insensitive.
        if (books.containsKey(name.toLowerCase())) {
            System.out.println("Error: A book with this title already exists.");
        } else {
            books.put(name.toLowerCase(), new Book(name));
        }
    }

    void viewBooks() {
        System.out.println("\nAvailable Books:");
        long availableCount = books.values().stream()
                .filter(Book::isAvailable)
                .peek(book -> System.out.println("- " + book.getBookName()))
                .count();

        if (availableCount == 0) {
            System.out.println("No books are currently available.");
        }
    }

    void borrowBook(String bookName, Member member) {
        Book book = books.get(bookName.toLowerCase());
        if (book == null) {
            System.out.println("Sorry, a book with the title \"" + bookName + "\" does not exist in our library.");
        } else if (book.isAvailable()) {
            book.borrow(member);
            System.out.println(member.getName() + " borrowed \"" + book.getBookName() + "\" successfully.");
        } else {
            System.out.println("Sorry, \"" + book.getBookName() + "\" is currently borrowed by " + book.getBorrowedBy().getName() + ".");
        }
    }

    void returnBook(String bookName, Member member) {
        Book book = books.get(bookName.toLowerCase());
        if (book == null) {
            System.out.println("Error: A book with the title \"" + bookName + "\" does not exist in our system.");
        } else if (book.isAvailable()) {
            System.out.println("Error: \"" + book.getBookName() + "\" was not borrowed.");
        } else if (book.getBorrowedBy() == member) {
            book.returnBook();
            System.out.println(member.getName() + " returned \"" + book.getBookName() + "\" successfully.");
        } else {
            System.out.println("Error: This book was borrowed by " + book.getBorrowedBy().getName() + ", not you.");
        }
    }
}

class LibraryService {
    private final Library library;
    private final Member member;

    public LibraryService(Library library, Member member) {
        this.library = library;
        this.member = member;
    }

    public void run() {
        try (Scanner sc = new Scanner(System.in)) {
            int option;
            do {
                System.out.println("\n==== Library Menu ====");
                System.out.println("1. View Available Books");
                System.out.println("2. Borrow a Book");
                System.out.println("3. Return a Book");
                System.out.println("4. Exit");
                System.out.print("Enter your choice: ");
                option = sc.nextInt();
                sc.nextLine(); // Consume the newline character

                switch (option) {
                    case 1:
                        library.viewBooks();
                        break;
                    case 2:
                        System.out.print("Enter book name to borrow: ");
                        String borrowName = sc.nextLine();
                        library.borrowBook(borrowName, member);
                        break;
                    case 3:
                        System.out.print("Enter book name to return: ");
                        String returnName = sc.nextLine();
                        library.returnBook(returnName, member);
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
        }
    }
}

public class MiniLibrary {
    public static void main(String[] args) {
        Library library = new Library();
        library.addBook("Java Made Easy");
        library.addBook("C Programming");
        library.addBook("Computer Networks");

        Scanner sc = new Scanner(System.in);
        System.out.print("Enter your name to become a library member: ");
        String userName = sc.nextLine();
        Member member = new Member(userName);
        System.out.println("Welcome, " + member.getName() + "!");

        LibraryService service = new LibraryService(library, member);
        service.run();
    }
}
