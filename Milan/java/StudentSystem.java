import java.util.*;

class Student {
    int roll;
    String name;
    double mark1, mark2, mark3;

    Student(int roll, String name, double mark1, double mark2, double mark3) {
        this.roll = roll;
        this.name = name;
        this.mark1 = mark1;
        this.mark2 = mark2;
        this.mark3 = mark3;
    }

    double total() {
        return mark1 + mark2 + mark3;
    }

    double average() {
        return total() / 3;
    }

    void display() {
        System.out.println("Roll: " + roll + " | Name: " + name + 
                           " | Total: " + total() + " | Average: " + average());
    }
}

public class StudentSystem {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        ArrayList<Student> list = new ArrayList<>();

        System.out.print("Enter number of students: ");
        int n = sc.nextInt();

        for (int i = 1; i <= n; i++) {
            System.out.println("\nEnter details for Student " + i + ":");
            System.out.print("Roll Number: ");
            int roll = sc.nextInt();
            sc.nextLine();
            System.out.print("Name: ");
            String name = sc.nextLine();
            System.out.print("Enter 3 subject marks: ");
            double m1 = sc.nextDouble();
            double m2 = sc.nextDouble();
            double m3 = sc.nextDouble();

            list.add(new Student(roll, name, m1, m2, m3));
        }

        System.out.println("\n=== Student Report ===");
        for (Student s : list) {
            s.display();
        }

        sc.close();
    }
}
