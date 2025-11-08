import java.util.*;

class Employee {
    int id;
    String name;
    double hours;
    double rate;

    Employee(int id, String name, double hours, double rate) {
        this.id = id;
        this.name = name;
        this.hours = hours;
        this.rate = rate;
    }

    double salary() {
        return hours * rate;
    }

    void show() {
        System.out.println("ID: " + id + " | Name: " + name + " | Salary: " + salary());
    }
}

public class PayrollSystem {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        ArrayList<Employee> empList = new ArrayList<>();

        System.out.print("Enter number of employees: ");
        int n = sc.nextInt();

        for (int i = 1; i <= n; i++) {
            System.out.println("\nEnter details of Employee " + i + ":");
            System.out.print("ID: ");
            int id = sc.nextInt();
            sc.nextLine();
            System.out.print("Name: ");
            String name = sc.nextLine();
            System.out.print("Hours Worked: ");
            double hours = sc.nextDouble();
            System.out.print("Hourly Rate: ");
            double rate = sc.nextDouble();

            empList.add(new Employee(id, name, hours, rate));
        }

        System.out.println("\n--- Payroll Report ---");
        for (Employee e : empList) {
            e.show();
        }

        sc.close();
    }
}
