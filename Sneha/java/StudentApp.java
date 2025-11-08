import java.util.*;

class Learner {
    int id;
    String studentName;
    double s1, s2, s3;

    Learner(int id, String studentName, double s1, double s2, double s3) {
        this.id = id;
        this.studentName = studentName;
        this.s1 = s1;
        this.s2 = s2;
        this.s3 = s3;
    }

    double getTotal() {
        return s1 + s2 + s3;
    }

    double getAverage() {
        return getTotal() / 3;
    }

    String getGrade() {
        double avg = getAverage();
        if (avg >= 90) return "A";
        else if (avg >= 75) return "B";
        else if (avg >= 60) return "C";
        else if (avg >= 40) return "D";
        else return "F";
    }

    void show() {
        System.out.println("ID: " + id + " | Name: " + studentName + 
            " | Total: " + getTotal() + " | Average: " + getAverage() + 
            " | Grade: " + getGrade());
    }
}

public class StudentApp {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        ArrayList<Learner> students = new ArrayList<>();

        System.out.print("Enter number of students: ");
        int n = sc.nextInt();

        for (int i = 1; i <= n; i++) {
            System.out.println("\nEnter details for student " + i + ":");
            System.out.print("Student ID: ");
            int id = sc.nextInt();
            sc.nextLine();
            System.out.print("Student Name: ");
            String name = sc.nextLine();
            System.out.print("Enter marks in 3 subjects: ");
            double a = sc.nextDouble();
            double b = sc.nextDouble();
            double c = sc.nextDouble();

            students.add(new Learner(id, name, a, b, c));
        }

        System.out.println("\n=== Student Report ===");
        for (Learner s : students) {
            s.show();
        }

        sc.close();
    }
}
