import java.util.*;

class StaffData {
    int code;
    String name;
    double hours;
    double rate;

    StaffData(int code, String name, double hours, double rate) {
        this.code = code;
        this.name = name;
        this.hours = hours;
        this.rate = rate;
    }

    double salary() {
        return hours * rate;
    }

    void printData() {
        System.out.println("Code: " + code + ", Name: " + name + ", Salary: " + salary());
    }
}

public class PayReport {
    public static void main(String[] args) {
        Scanner in = new Scanner(System.in);
        ArrayList<StaffData> staffList = new ArrayList<>();

        System.out.print("Enter number of staff: ");
        int n = in.nextInt();

        for (int i = 1; i <= n; i++) {
            System.out.println("\nEnter details of Staff " + i + ":");
            System.out.print("Code: ");
            int c = in.nextInt();
            in.nextLine();
            System.out.print("Name: ");
            String nm = in.nextLine();
            System.out.print("Hours Worked: ");
            double h = in.nextDouble();
            System.out.print("Rate per Hour: ");
            double r = in.nextDouble();

            staffList.add(new StaffData(c, nm, h, r));
        }

        System.out.println("\n=== Pay Report ===");
        for (StaffData s : staffList) {
            s.printData();
        }

        in.close();
    }
}
