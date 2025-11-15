import java.util.*;

/**
 * Represents an Employee with encapsulated data.
 * Fields are private and accessed via public getters.
 */
class Employee {
    private final int id;
    private final String name;
    private double hoursWorked;
    private double hourlyRate;

    public Employee(int id, String name, double hoursWorked, double hourlyRate) {
        this.id = id;
        this.name = name;
        this.hoursWorked = hoursWorked;
        this.hourlyRate = hourlyRate;
    }

    public int getId() {
        return id;
    }

    public String getName() {
        return name;
    }

    public double getHoursWorked() {
        return hoursWorked;
    }

    public double getHourlyRate() {
        return hourlyRate;
    }

    public double calculateSalary() {
        return hoursWorked * hourlyRate;
    }

    @Override
    public String toString() {
        return String.format("ID: %-5d | Name: %-20s | Salary: $%.2f", id, name, calculateSalary());
    }
}

/**
 * Manages the collection of employees and payroll operations.
 * Uses a TreeMap for efficient, sorted storage of employees by ID.
 */
class Payroll {
    private final Map<Integer, Employee> employees = new TreeMap<>();

    public boolean addEmployee(Employee employee) {
        if (employees.containsKey(employee.getId())) {
            System.out.println("Error: An employee with ID " + employee.getId() + " already exists.");
            return false;
        }
        employees.put(employee.getId(), employee);
        return true;
    }

    public void generateReport() {
        System.out.println("\n--- Payroll Report ---");
        if (employees.isEmpty()) {
            System.out.println("No employees in the system.");
        } else {
            employees.values().forEach(System.out::println);
        }
    }
}

public class PayrollSystem {
    public static void main(String[] args) {
        try (Scanner sc = new Scanner(System.in)) {
            Payroll payroll = new Payroll();
            int choice = 0;

            while (choice != 3) {
                System.out.println("\n==== Payroll Menu ====");
                System.out.println("1. Add Employee");
                System.out.println("2. Generate Payroll Report");
                System.out.println("3. Exit");
                System.out.print("Enter your choice: ");

                try {
                    choice = sc.nextInt();
                    sc.nextLine(); // Consume newline

                    switch (choice) {
                        case 1:
                            addEmployee(sc, payroll);
                            break;
                        case 2:
                            payroll.generateReport();
                            break;
                        case 3:
                            System.out.println("Exiting Payroll System. Goodbye!");
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

    private static void addEmployee(Scanner sc, Payroll payroll) {
        try {
            System.out.println("\nEnter New Employee Details:");
            System.out.print("ID: ");
            int id = sc.nextInt();
            sc.nextLine(); // Consume newline

            System.out.print("Name: ");
            String name = sc.nextLine();

            System.out.print("Hours Worked: ");
            double hours = sc.nextDouble();

            System.out.print("Hourly Rate: ");
            double rate = sc.nextDouble();

            if (hours < 0 || rate < 0) {
                System.out.println("Error: Hours worked and hourly rate cannot be negative.");
                return;
            }

            Employee newEmployee = new Employee(id, name, hours, rate);
            if (payroll.addEmployee(newEmployee)) {
                System.out.println("Employee added successfully!");
            }

        } catch (InputMismatchException e) {
            System.out.println("Invalid input. Please enter correct data types (integer for ID, numbers for hours/rate).");
            sc.nextLine(); // Clear the rest of the invalid line
        }
    }
}
