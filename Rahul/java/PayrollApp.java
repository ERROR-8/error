import java.util.*;

class Staff {
    int id;
    String personName;
    double timeWorked;
    double payRate;

    Staff(int id, String personName, double timeWorked, double payRate) {
        this.id = id;
        this.personName = personName;
        this.timeWorked = timeWorked;
        this.payRate = payRate;
    }

    double totalPay() {
        return timeWorked * payRate;
    }

    void showData() {
        System.out.println("ID: " + id + ", Name: " + personName + ", Salary: " + totalPay());
    }
}

public class PayrollApp {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        ArrayList<Staff> list = new ArrayList<>();

        System.out.print("Enter number of staff: ");
        int count = sc.nextInt();

        for (int i = 1; i <= count; i++) {
            System.out.println("\nEnter info for staff " + i + ":");
            System.out.print("ID: ");
            int id = sc.nextInt();
            sc.nextLine();
            System.out.print("Name: ");
            String name = sc.nextLine();
            System.out.print("Hours Worked: ");
            double hrs = sc.nextDouble();
            System.out.print("Rate per Hour: ");
            double rate = sc.nextDouble();

            list.add(new Staff(id, name, hrs, rate));
        }

        System.out.println("\n=== Salary Report ===");
        for (Staff s : list) {
            s.showData();
        }

        sc.close();
    }
}
