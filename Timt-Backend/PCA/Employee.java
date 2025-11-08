import java.util.Scanner;

public class Employee {
    private int id;
    private String name;
    private double salary;
    private String address;

    // Constructor
    public Employee(int id, String name, double salary, String address) {
        this.id = id;
        this.name = name;
        this.salary = salary;
        this.address = address;
    }

    // Method to display employee details
    public void display() {
        System.out.println("Employee ID: " + id);
        System.out.println("Name: " + name);
        System.out.println("Salary: " + salary);
        System.out.println("Address: " + address);
    }

    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);

        System.out.print("Enter Employee ID: ");
        int id = sc.nextInt();
        sc.nextLine(); // consume newline

        System.out.print("Enter Employee Name: ");
        String name = sc.nextLine();

        System.out.print("Enter Employee Salary: ");
        double salary = sc.nextDouble();
        sc.nextLine(); // consume newline

        System.out.print("Enter Employee Address: ");
        String address = sc.nextLine();

        Employee emp = new Employee(id, name, salary, address);
        System.out.println("\nEmployee Details:");
        emp.display();
    }
}