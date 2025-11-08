import java.util.*;

class VehicleInfo {
    String vehicleName;
    boolean isAvailable;

    VehicleInfo(String vehicleName) {
        this.vehicleName = vehicleName;
        this.isAvailable = true;
    }

    void rentVehicle() {
        if (isAvailable) {
            isAvailable = false;
            System.out.println(vehicleName + " rented successfully.");
        } else {
            System.out.println(vehicleName + " is not available right now.");
        }
    }

    void returnBack() {
        if (!isAvailable) {
            isAvailable = true;
            System.out.println(vehicleName + " returned successfully.");
        } else {
            System.out.println(vehicleName + " was not rented.");
        }
    }

    void showStatus() {
        if (isAvailable)
            System.out.println(vehicleName + " is available for rent.");
        else
            System.out.println(vehicleName + " is already rented.");
    }
}

class Car extends VehicleInfo {
    Car(String vehicleName) {
        super(vehicleName);
    }
}

class Bike extends VehicleInfo {
    Bike(String vehicleName) {
        super(vehicleName);
    }
}

class Truck extends VehicleInfo {
    Truck(String vehicleName) {
        super(vehicleName);
    }
}

public class RentalApp {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);

        Car car = new Car("Swift Car");
        Bike bike = new Bike("Hero Bike");
        Truck truck = new Truck("Eicher Truck");

        int ch;
        do {
            System.out.println("\n--- Vehicle Rental System ---");
            System.out.println("1. Check Vehicle");
            System.out.println("2. Rent Vehicle");
            System.out.println("3. Return Vehicle");
            System.out.println("4. Exit");
            System.out.print("Enter your choice: ");
            ch = sc.nextInt();
            sc.nextLine(); // clear buffer

            System.out.print("Enter vehicle type (car/bike/truck): ");
            String type = sc.nextLine().toLowerCase();
            VehicleInfo v = null;

            if (type.equals("car")) v = car;
            else if (type.equals("bike")) v = bike;
            else if (type.equals("truck")) v = truck;
            else {
                System.out.println("Invalid type entered!");
                continue;
            }

            switch (ch) {
                case 1:
                    v.showStatus();
                    break;
                case 2:
                    v.rentVehicle();
                    break;
                case 3:
                    v.returnBack();
                    break;
                case 4:
                    System.out.println("Exiting system... Thank you!");
                    break;
                default:
                    System.out.println("Invalid choice!");
            }
        } while (ch != 4);

        sc.close();
    }
}
