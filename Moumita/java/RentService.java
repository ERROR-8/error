import java.util.*;

class Vehicle {
    String name;
    boolean available;

    Vehicle(String name) {
        this.name = name;
        this.available = true;
    }

    void checkAvailability() {
        if (available)
            System.out.println(name + " is available for rent.");
        else
            System.out.println(name + " is already rented.");
    }

    void rentVehicle() {
        if (available) {
            available = false;
            System.out.println(name + " has been rented successfully.");
        } else {
            System.out.println(name + " is not available right now.");
        }
    }

    void returnVehicle() {
        if (!available) {
            available = true;
            System.out.println(name + " has been returned successfully.");
        } else {
            System.out.println(name + " was not rented yet.");
        }
    }
}

class Car extends Vehicle {
    Car(String name) {
        super(name);
    }
}

class Bike extends Vehicle {
    Bike(String name) {
        super(name);
    }
}

class Truck extends Vehicle {
    Truck(String name) {
        super(name);
    }
}

public class RentService {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);

        Car car = new Car("Maruti Car");
        Bike bike = new Bike("Pulsar Bike");
        Truck truck = new Truck("Ashok Truck");

        int choice;
        do {
            System.out.println("\n==== Vehicle Rental System ====");
            System.out.println("1. Check Availability");
            System.out.println("2. Rent Vehicle");
            System.out.println("3. Return Vehicle");
            System.out.println("4. Exit");
            System.out.print("Enter your choice: ");
            choice = sc.nextInt();
            sc.nextLine();

            System.out.print("Enter vehicle type (car/bike/truck): ");
            String type = sc.nextLine().toLowerCase();

            Vehicle v = null;

            switch (type) {
                case "car":
                    v = car;
                    break;
                case "bike":
                    v = bike;
                    break;
                case "truck":
                    v = truck;
                    break;
                default:
                    System.out.println("Invalid vehicle type entered!");
                    continue;
            }

            switch (choice) {
                case 1:
                    v.checkAvailability();
                    break;
                case 2:
                    v.rentVehicle();
                    break;
                case 3:
                    v.returnVehicle();
                    break;
                case 4:
                    System.out.println("Thank you for using our rental service!");
                    break;
                default:
                    System.out.println("Invalid choice!");
            }
        } while (choice != 4);

        sc.close();
    }
}
