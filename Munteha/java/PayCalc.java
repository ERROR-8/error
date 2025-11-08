import java.util.*;

class EmpData {
    int empId;
    String empName;
    double hrs;
    double rate;

    EmpData(int empId, String empName, double hrs, double rate) {
        this.empId = empId;
        this.empName = empName;
        this.hrs = hrs;
        this.rate = rate;
    }

    double findSalary() {
        return hrs * rate;
    }

    void display() {
        System.out.println("Emp ID: " + empId + ", Name: " + empName + ", Total Pay: " + findSalary());
    }
}

public class PayCalc {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        ArrayList<EmpData> data = new ArrayList<>();

        System.out.print("Enter total employees: ");
        int n = sc.nextInt();

        for (int i = 1; i <= n; i++) {
            System.out.println("\nEnter details of Employee " + i + ":");
            System.out.print("Employee ID: ");
            int id = sc.nextInt();
            sc.nextLine(); 
            System.out.print("Employee Name: ");
            String name = sc.nextLine();
            System.out.print("Worked Hours: ");
            double h = sc.nextDouble();
            System.out.print("Hourly Rate: ");
            double r = sc.nextDouble();

            data.add(new EmpData(id, name, h, r));
        }

        System.out.println("\n----- Payroll Summary -----");
        for (EmpData e : data) {
            e.display();
        }

        sc.close();
    }
}
