import java.util.*;

class Vehicle {
    String name;
    boolean available;

    Vehicle(String name) {
        this.name = name;
        this.available = true;
    }

    void rent() {
        if (available) {
            available = false;
            System.out.println(name + " has been rented.");
        } else {
            System.out.println(name + " is already rented!");
        }
    }

    void returnVehicle() {
        if (!available) {
            available = true;
            System.out.println(name + " has been returned.");
        } else {
            System.out.println(name + " was not rented.");
        }
    }

    void checkAvailability() {
        if (available)
            System.out.println(name + " is available for rent.");
        else
            System.out.println(name + " is not available.");
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

public class RentalSystem {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);

        // Create some vehicles
        Car car = new Car("Honda City");
        Bike bike = new Bike("Yamaha FZ");
        Truck truck = new Truck("Tata Truck");

        int choice;
        do {
            System.out.println("\n=== Vehicle Rental Menu ===");
            System.out.println("1. Check Availability");
            System.out.println("2. Rent Vehicle");
            System.out.println("3. Return Vehicle");
            System.out.println("4. Exit");
            System.out.print("Enter your choice: ");
            choice = sc.nextInt();
            sc.nextLine();

            System.out.println("Select Vehicle (car/bike/truck): ");
            String type = sc.nextLine().toLowerCase();
            Vehicle v = null;

            if (type.equals("car"))
                v = car;
            else if (type.equals("bike"))
                v = bike;
            else if (type.equals("truck"))
                v = truck;
            else {
                System.out.println("Invalid vehicle type!");
                continue;
            }

            switch (choice) {
                case 1:
                    v.checkAvailability();
                    break;
                case 2:
                    v.rent();
                    break;
                case 3:
                    v.returnVehicle();
                    break;
                case 4:
                    System.out.println("Thank you for using our rental service!");
                    break;
                default:
                    System.out.println("Invalid option!");
            }
        } while (choice != 4);

        sc.close();
    }
}
