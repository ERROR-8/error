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

public class PayrollApp {
    public static void main(String[] args) {
        try (Scanner sc = new Scanner(System.in)) {
            List<Staff> staffList = new ArrayList<>();

            System.out.print("Enter number of staff: ");
            int count = sc.nextInt();

            for (int i = 1; i <= count; i++) {
                System.out.println("\nEnter info for staff member " + i + ":");
                System.out.print("ID: ");
                int id = sc.nextInt();
                sc.nextLine(); // Consume newline

                System.out.print("Name: ");
                String name = sc.nextLine();

                System.out.print("Hours Worked: ");
                BigDecimal hoursWorked = sc.nextBigDecimal();

                System.out.print("Rate per Hour: ");
                BigDecimal hourlyRate = sc.nextBigDecimal();

                if (hoursWorked.compareTo(BigDecimal.ZERO) < 0 || hourlyRate.compareTo(BigDecimal.ZERO) < 0) {
                    System.out.println("Hours worked and rate must be non-negative. Please try again.");
                    i--; // Redo the current staff member entry
                    continue;
                }

                staffList.add(new Staff(id, name, hoursWorked, hourlyRate));
            }

            System.out.println("\n=== Salary Report ===");
            for (Staff staff : staffList) {
                System.out.println(staff); // Implicitly calls staff.toString()
            }
        } catch (InputMismatchException e) {
            System.err.println("Invalid input. Please enter correct data types. Exiting.");
        }
    }
}
