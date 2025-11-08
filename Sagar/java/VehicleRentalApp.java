import java.util.*;

class VehicleData {
    String vehicleName;
    boolean status;

    VehicleData(String vehicleName) {
        this.vehicleName = vehicleName;
        this.status = true; // available by default
    }

    void showAvailability() {
        if (status)
            System.out.println(vehicleName + " is available for rent.");
        else
            System.out.println(vehicleName + " is currently rented.");
    }

    void rentVehicle() {
        if (status) {
            status = false;
            System.out.println(vehicleName + " rented successfully.");
        } else {
            System.out.println(vehicleName + " is not available right now!");
        }
    }

    void returnVehicle() {
        if (!status) {
            status = true;
            System.out.println(vehicleName + " returned successfully.");
        } else {
            System.out.println(vehicleName + " was not rented.");
        }
    }
}

class Car extends VehicleData {
    Car(String name) {
        super(name);
    }
}

class Bike extends VehicleData {
    Bike(String name) {
        super(name);
    }
}

class Truck extends VehicleData {
    Truck(String name) {
        super(name);
    }
}

public class VehicleRentalApp {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);

        Car c1 = new Car("Swift Car");
        Bike b1 = new Bike("Honda Bike");
        Truck t1 = new Truck("Tata Truck");

        int choice;
        do {
            System.out.println("\n--- Vehicle Rental Service ---");
            System.out.println("1. Check Vehicle");
            System.out.println("2. Rent Vehicle");
            System.out.println("3. Return Vehicle");
            System.out.println("4. Exit");
            System.out.print("Enter your choice: ");
            choice = sc.nextInt();
            sc.nextLine();

            System.out.print("Enter vehicle type (car/bike/truck): ");
            String type = sc.nextLine().toLowerCase();

            VehicleData v = null;

            if (type.equals("car"))
                v = c1;
            else if (type.equals("bike"))
                v = b1;
            else if (type.equals("truck"))
                v = t1;
            else {
                System.out.println("Invalid type entered!");
                continue;
            }

            switch (choice) {
                case 1:
                    v.showAvailability();
                    break;
                case 2:
                    v.rentVehicle();
                    break;
                case 3:
                    v.returnVehicle();
                    break;
                case 4:
                    System.out.println("Thank you for visiting our rental service!");
                    break;
                default:
                    System.out.println("Invalid option!");
            }
        } while (choice != 4);

        sc.close();
    }
}
