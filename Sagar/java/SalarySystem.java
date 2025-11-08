import java.util.*;

class Worker {
    int empNo;
    String empName;
    double workHours;
    double ratePerHour;

    Worker(int empNo, String empName, double workHours, double ratePerHour) {
        this.empNo = empNo;
        this.empName = empName;
        this.workHours = workHours;
        this.ratePerHour = ratePerHour;
    }

    double getPay() {
        return workHours * ratePerHour;
    }

    void printInfo() {
        System.out.println("Emp No: " + empNo + ", Name: " + empName + ", Pay: " + getPay());
    }
}

public class SalarySystem {
    public static void main(String[] args) {
        Scanner input = new Scanner(System.in);
        ArrayList<Worker> workers = new ArrayList<>();

        System.out.print("How many employees? ");
        int total = input.nextInt();

        for (int i = 1; i <= total; i++) {
            System.out.println("\nEnter details for employee " + i + ":");
            System.out.print("Employee No: ");
            int eno = input.nextInt();
            input.nextLine(); // clear buffer
            System.out.print("Employee Name: ");
            String ename = input.nextLine();
            System.out.print("Total Hours Worked: ");
            double hrs = input.nextDouble();
            System.out.print("Hourly Rate: ");
            double rate = input.nextDouble();

            workers.add(new Worker(eno, ename, hrs, rate));
        }

        System.out.println("\n----- Payroll Report -----");
        for (Worker w : workers) {
            w.printInfo();
        }

        input.close();
    }
}
