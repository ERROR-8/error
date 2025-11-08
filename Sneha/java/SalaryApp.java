import java.util.*;

class Worker {
    int empNo;
    String empName;
    double workHours;
    double payRate;

    Worker(int empNo, String empName, double workHours, double payRate) {
        this.empNo = empNo;
        this.empName = empName;
        this.workHours = workHours;
        this.payRate = payRate;
    }

    double totalPay() {
        return workHours * payRate;
    }

    void display() {
        System.out.println("Emp No: " + empNo + " | Name: " + empName + " | Pay: " + totalPay());
    }
}

public class SalaryApp {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        ArrayList<Worker> workers = new ArrayList<>();

        System.out.print("Enter number of employees: ");
        int n = sc.nextInt();

        for (int i = 1; i <= n; i++) {
            System.out.println("\nEnter details for Employee " + i + ":");
            System.out.print("Employee No: ");
            int no = sc.nextInt();
            sc.nextLine();
            System.out.print("Employee Name: ");
            String name = sc.nextLine();
            System.out.print("Hours Worked: ");
            double hrs = sc.nextDouble();
            System.out.print("Hourly Pay: ");
            double rate = sc.nextDouble();

            workers.add(new Worker(no, name, hrs, rate));
        }

        System.out.println("\n=== Salary Report ===");
        for (Worker w : workers) {
            w.display();
        }

        sc.close();
    }
}
