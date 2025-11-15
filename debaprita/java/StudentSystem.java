import java.util.*;

/**
 * Represents a Student with encapsulated data.
 * Fields are private and accessed via public getters.
 */
class Student {
    private final int rollNumber;
    private final String name;
    private final double mark1;
    private final double mark2;
    private final double mark3;

    public Student(int rollNumber, String name, double mark1, double mark2, double mark3) {
        this.rollNumber = rollNumber;
        this.name = name;
        this.mark1 = mark1;
        this.mark2 = mark2;
        this.mark3 = mark3;
    }

    public int getRollNumber() {
        return rollNumber;
    }

    public String getName() {
        return name;
    }

    public double getTotalMarks() {
        return mark1 + mark2 + mark3;
    }

    public double getAverageMarks() {
        return getTotalMarks() / 3.0;
    }

    @Override
    public String toString() {
        return String.format("Roll: %-5d | Name: %-20s | Total: %-7.2f | Average: %.2f",
                rollNumber, name, getTotalMarks(), getAverageMarks());
    }
}

/**
 * Manages the collection of students and related operations.
 * Uses a TreeMap for efficient, sorted storage of students by roll number.
 */
class StudentRegistry {
    private final Map<Integer, Student> students = new TreeMap<>();

    public boolean addStudent(Student student) {
        if (students.containsKey(student.getRollNumber())) {
            System.out.println("Error: A student with Roll Number " + student.getRollNumber() + " already exists.");
            return false;
        }
        students.put(student.getRollNumber(), student);
        return true;
    }

    public void generateReport() {
        System.out.println("\n--- Student Report ---");
        if (students.isEmpty()) {
            System.out.println("No students in the registry.");
        } else {
            students.values().forEach(System.out::println);
        }
    }
}

public class StudentSystem {
    public static void main(String[] args) {
        try (Scanner sc = new Scanner(System.in)) {
            StudentRegistry registry = new StudentRegistry();
            int choice = 0;

            while (choice != 3) {
                System.out.println("\n==== Student Menu ====");
                System.out.println("1. Add Student");
                System.out.println("2. Generate Student Report");
                System.out.println("3. Exit");
                System.out.print("Enter your choice: ");

                try {
                    choice = sc.nextInt();
                    sc.nextLine(); // Consume newline

                    switch (choice) {
                        case 1:
                            addStudent(sc, registry);
                            break;
                        case 2:
                            registry.generateReport();
                            break;
                        case 3:
                            System.out.println("Exiting Student System. Goodbye!");
                            break;
                        default:
                            System.out.println("Invalid choice. Please enter a number between 1 and 3.");
                    }
                } catch (InputMismatchException e) {
                    System.out.println("Invalid input. Please enter a valid number for the menu choice.");
                    sc.nextLine(); // Clear the invalid input from the scanner
                }
            }
        }
    }

    private static void addStudent(Scanner sc, StudentRegistry registry) {
        try {
            System.out.println("\nEnter New Student Details:");
            System.out.print("Roll Number: ");
            int roll = sc.nextInt();
            sc.nextLine(); // Consume newline

            System.out.print("Name: ");
            String name = sc.nextLine();

            System.out.print("Enter marks for Subject 1: ");
            double m1 = sc.nextDouble();
            System.out.print("Enter marks for Subject 2: ");
            double m2 = sc.nextDouble();
            System.out.print("Enter marks for Subject 3: ");
            double m3 = sc.nextDouble();

            if (m1 < 0 || m2 < 0 || m3 < 0) {
                System.out.println("Error: Marks cannot be negative.");
                return;
            }

            Student newStudent = new Student(roll, name, m1, m2, m3);
            if (registry.addStudent(newStudent)) {
                System.out.println("Student added successfully!");
            }

        } catch (InputMismatchException e) {
            System.out.println("Invalid input. Please enter correct data types (integer for roll, numbers for marks).");
            sc.nextLine(); // Clear the rest of the invalid line
        }
    }
}
