import java.util.*;

class Vehicle {
    String name;
    boolean available;

    Vehicle(String name) {
        this.name = name;
        this.available = true;
    }

    void check() {
        if (available)
            System.out.println(name + " is available.");
        else
            System.out.println(name + " is not available.");
    }

    void rent() {
        if (available) {
            available = false;
            System.out.println("You have rented " + name + ".");
        } else {
            System.out.println(name + " is already rented!");
        }
    }

    void giveBack() {
        if (!available) {
            available = true;
            System.out.println(name + " has been returned.");
        } else {
            System.out.println(name + " was not rented.");
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

public class RentSystem {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);

        Car car = new Car("Honda City");
        Bike bike = new Bike("Royal Enfield");
        Truck truck = new Truck("Tata Ace");

        int choice;
        do {
            System.out.println("\n==== Vehicle Rental Menu ====");
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
                    System.out.println("Invalid vehicle type!");
                    continue;
            }

            switch (choice) {
                case 1:
                    v.check();
                    break;
                case 2:
                    v.rent();
                    break;
                case 3:
                    v.giveBack();
                    break;
                case 4:
                    System.out.println("Thanks for using our rental service!");
                    break;
                default:
                    System.out.println("Wrong choice!");
            }
        } while (choice != 4);

        sc.close();
    }
}
