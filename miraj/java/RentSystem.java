import java.util.*;

class Vehicle {
    private final String name;
    private final String type;
    private boolean isAvailable;

    public Vehicle(String name, String type) {
        this.name = name;
        this.type = type;
        this.isAvailable = true;
    }

    public String getName() {
        return name;
    }

    public String getType() {
        return type;
    }

    public boolean isAvailable() {
        return isAvailable;
    }

    public boolean rent() {
        if (isAvailable) {
            isAvailable = false;
            return true;
        }
        return false;
    }

    public boolean giveBack() {
        if (!isAvailable) {
            isAvailable = true;
            return true;
        }
        return false;
    }

    @Override
    public String toString() {
        return String.format("'%s' (%s) - %s", name, type, isAvailable ? "Available" : "Rented");
    }
}

public class RentSystem {
    public static void main(String[] args) {
        Map<String, Vehicle> vehicleFleet = new LinkedHashMap<>();
        vehicleFleet.put("honda city", new Vehicle("Honda City", "Car"));
        vehicleFleet.put("royal enfield", new Vehicle("Royal Enfield", "Bike"));
        vehicleFleet.put("tata ace", new Vehicle("Tata Ace", "Truck"));

        try (Scanner sc = new Scanner(System.in)) {
            int choice;
            do {
                System.out.println("\n==== Vehicle Rental Menu ====");
                System.out.println("1. Show All Vehicles");
                System.out.println("2. Rent Vehicle");
                System.out.println("3. Return Vehicle");
                System.out.println("4. Exit");
                System.out.print("Enter your choice: ");
                choice = sc.nextInt();
                sc.nextLine(); // Consume newline

                switch (choice) {
                    case 1:
                        System.out.println("\n--- Vehicle Fleet Status ---");
                        for (Vehicle v : vehicleFleet.values()) {
                            System.out.println(v);
                        }
                        break;

                    case 2:
                        System.out.print("Enter vehicle name to rent: ");
                        String rentName = sc.nextLine().toLowerCase();
                        Vehicle toRent = vehicleFleet.get(rentName);
                        if (toRent == null) {
                            System.out.println("Sorry, we don't have a vehicle with that name.");
                        } else {
                            if (toRent.rent()) {
                                System.out.println("You have successfully rented '" + toRent.getName() + "'.");
                            } else {
                                System.out.println("Sorry, '" + toRent.getName() + "' is already rented.");
                            }
                        }
                        break;

                    case 3:
                        System.out.print("Enter vehicle name to return: ");
                        String returnName = sc.nextLine().toLowerCase();
                        Vehicle toReturn = vehicleFleet.get(returnName);
                        if (toReturn == null) {
                            System.out.println("Error: We don't have a vehicle with that name in our system.");
                        } else {
                            if (toReturn.giveBack()) {
                                System.out.println("Thank you for returning '" + toReturn.getName() + "'.");
                            } else {
                                System.out.println("Error: '" + toReturn.getName() + "' was not rented out.");
                            }
                        }
                        break;

                    case 4:
                        System.out.println("Thanks for using our rental service!");
                        break;

                    default:
                        System.out.println("Invalid choice! Please try again.");
                }
            } while (choice != 4);
        } catch (InputMismatchException e) {
            System.err.println("Invalid input. Please enter a number for the menu choice.");
        }
    }
}
