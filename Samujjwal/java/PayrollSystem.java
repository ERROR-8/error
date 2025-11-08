import java.util.*;

class Employee {
    int id;
    String name;
    double hoursWorked;
    double hourlyRate;

    Employee(int id, String name, double hoursWorked, double hourlyRate) {
        this.id = id;
        this.name = name;
        this.hoursWorked = hoursWorked;
        this.hourlyRate = hourlyRate;
    }

    double calculateSalary() {
        return hoursWorked * hourlyRate;
    }

    void showDetails() {
        System.out.println("ID: " + id + ", Name: " + name + ", Salary: " + calculateSalary());
    }
}

public class PayrollSystem {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        ArrayList<Employee> empList = new ArrayList<>();

        System.out.print("Enter number of employees: ");
        int n = sc.nextInt();

        for (int i = 1; i <= n; i++) {
            System.out.println("\nEnter details for Employee " + i + ":");
            System.out.print("ID: ");
            int id = sc.nextInt();
            sc.nextLine(); // clear buffer
            System.out.print("Name: ");
            String name = sc.nextLine();
            System.out.print("Hours Worked: ");
            double hours = sc.nextDouble();
            System.out.print("Hourly Rate: ");
            double rate = sc.nextDouble();

            empList.add(new Employee(id, name, hours, rate));
        }

        System.out.println("\n=== Payroll Report ===");
        for (Employee e : empList) {
            e.showDetails();
        }

        sc.close();
    }
}
