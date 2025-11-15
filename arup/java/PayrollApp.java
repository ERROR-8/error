import java.util.*;
import java.math.BigDecimal;
import java.math.RoundingMode;

class Staff {
    private final int id;
    private final String name;
    private final BigDecimal hoursWorked;
    private final BigDecimal payRate;

    public Staff(int id, String name, BigDecimal hoursWorked, BigDecimal payRate) {
        this.id = id;
        this.name = name;
        this.hoursWorked = hoursWorked;
        this.payRate = payRate;
    }

    public int getId() {
        return id;
    }

    public String getName() {
        return name;
    }

    public BigDecimal getTotalPay() {
        return hoursWorked.multiply(payRate).setScale(2, RoundingMode.HALF_UP);
    }

    @Override
    public String toString() {
        return "ID: " + id + ", Name: " + name + ", Salary: $" + getTotalPay();
    }
}

class Company {
    private final List<Staff> staffList = new ArrayList<>();
    private final Map<Integer, Staff> staffById = new HashMap<>();

    public boolean addStaff(Staff staff) {
        if (staffById.containsKey(staff.getId())) {
            return false; // Indicate failure: duplicate ID
        }
        staffList.add(staff);
        staffById.put(staff.getId(), staff);
        return true; // Indicate success
    }

    public void generatePayrollReport() {
        System.out.println("\n=== Salary Report ===");
        if (staffList.isEmpty()) {
            System.out.println("No staff members have been added yet.");
            return;
        }
        for (Staff staff : staffList) {
            System.out.println(staff); // Implicitly calls staff.toString()
        }
    }
}

class PayrollService {
    private final Company company;
    private final Scanner scanner;

    public PayrollService(Company company, Scanner scanner) {
        this.company = company;
        this.scanner = scanner;
    }

    public void run() {
        int choice;
        do {
            System.out.println("\n==== Payroll Menu ====");
            System.out.println("1. Add Staff Members");
            System.out.println("2. Generate Payroll Report");
            System.out.println("3. Exit");
            System.out.print("Enter your choice: ");
            choice = scanner.nextInt();
            scanner.nextLine(); // Consume newline

            switch (choice) {
                case 1:
                    hireStaff();
                    break;
                case 2:
                    company.generatePayrollReport();
                    break;
                case 3:
                    System.out.println("Exiting Payroll Application.");
                    break;
                default:
                    System.out.println("Invalid choice. Please try again.");
            }
        } while (choice != 3);
    }

    private void hireStaff() {
        System.out.print("Enter number of staff to add: ");
        int count = scanner.nextInt();
        scanner.nextLine(); // Consume newline

        for (int i = 1; i <= count; i++) {
            System.out.println("\nEnter info for staff member " + i + ":");
            System.out.print("ID: ");
            int id = scanner.nextInt();
            scanner.nextLine(); // Consume newline

            System.out.print("Name: ");
            String name = scanner.nextLine();

            BigDecimal hoursWorked;
            do {
                System.out.print("Hours Worked: ");
                hoursWorked = scanner.nextBigDecimal();
                if (hoursWorked.compareTo(BigDecimal.ZERO) < 0) {
                    System.out.println("Hours worked cannot be negative. Please try again.");
                }
            } while (hoursWorked.compareTo(BigDecimal.ZERO) < 0);

            BigDecimal hourlyRate;
            do {
                System.out.print("Rate per Hour: ");
                hourlyRate = scanner.nextBigDecimal();
                if (hourlyRate.compareTo(BigDecimal.ZERO) < 0) {
                    System.out.println("Hourly rate cannot be negative. Please try again.");
                }
            } while (hourlyRate.compareTo(BigDecimal.ZERO) < 0);

            Staff newStaff = new Staff(id, name, hoursWorked, hourlyRate);
            if (company.addStaff(newStaff)) {
                System.out.println("Staff member '" + name + "' added successfully.");
            } else {
                System.out.println("Error: A staff member with ID " + id + " already exists.");
            }
        }
    }
}

public class PayrollApp {
    public static void main(String[] args) {
        try (Scanner sc = new Scanner(System.in)) {
            Company company = new Company();
            PayrollService service = new PayrollService(company, sc);
            service.run();
        } catch (InputMismatchException e) {
            System.err.println("Invalid input. Please enter correct data types. Exiting.");
        }
    }
}
