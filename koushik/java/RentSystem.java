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

class RentalAgency {
    private final Map<String, Vehicle> vehicleFleet = new LinkedHashMap<>();

    public void addVehicle(Vehicle vehicle) {
        vehicleFleet.put(vehicle.getName().toLowerCase(), vehicle);
    }

    public void generateFleetReport() {
        System.out.println("\n--- Vehicle Fleet Status ---");
        if (vehicleFleet.isEmpty()) {
            System.out.println("There are no vehicles in the fleet.");
            return;
        }
        for (Vehicle v : vehicleFleet.values()) {
            System.out.println(v);
        }
    }

    public Vehicle findVehicle(String name) {
        return vehicleFleet.get(name.toLowerCase());
    }
}

class RentalService {
    private final RentalAgency agency;
    private final Scanner scanner;

    public RentalService(RentalAgency agency, Scanner scanner) {
        this.agency = agency;
        this.scanner = scanner;
    }

    public void run() {
        int choice;
        do {
            printMenu();
            choice = scanner.nextInt();
            scanner.nextLine(); // Consume newline

            switch (choice) {
                case 1:
                    agency.generateFleetReport();
                    break;
                case 2:
                    processRental();
                    break;
                case 3:
                    processReturn();
                    break;
                case 4:
                    System.out.println("Thanks for using our rental service!");
                    break;
                default:
                    System.out.println("Invalid choice! Please try again.");
            }
        } while (choice != 4);
    }

    private void printMenu() {
        System.out.println("\n==== Vehicle Rental Menu ====");
        System.out.println("1. Show All Vehicles");
        System.out.println("2. Rent Vehicle");
        System.out.println("3. Return Vehicle");
        System.out.println("4. Exit");
        System.out.print("Enter your choice: ");
    }

    private void processRental() {
        System.out.print("Enter vehicle name to rent: ");
        String rentName = scanner.nextLine();
        Vehicle toRent = agency.findVehicle(rentName);
        if (toRent == null) {
            System.out.println("Sorry, we don't have a vehicle with that name.");
        } else if (toRent.rent()) {
            System.out.println("You have successfully rented '" + toRent.getName() + "'.");
        } else {
            System.out.println("Sorry, '" + toRent.getName() + "' is already rented.");
        }
    }

    private void processReturn() {
        System.out.print("Enter vehicle name to return: ");
        String returnName = scanner.nextLine();
        Vehicle toReturn = agency.findVehicle(returnName);
        if (toReturn == null) {
            System.out.println("Error: We don't have a vehicle with that name in our system.");
        } else if (toReturn.giveBack()) {
            System.out.println("Thank you for returning '" + toReturn.getName() + "'.");
        } else {
            System.out.println("Error: '" + toReturn.getName() + "' was not rented out.");
        }
    }
}

public class RentSystem {
    public static void main(String[] args) {
        RentalAgency agency = new RentalAgency();
        agency.addVehicle(new Vehicle("Honda City", "Car"));
        agency.addVehicle(new Vehicle("Royal Enfield", "Bike"));
        agency.addVehicle(new Vehicle("Tata Ace", "Truck"));

        try (Scanner sc = new Scanner(System.in)) {
            RentalService service = new RentalService(agency, sc);
            service.run();
        } catch (InputMismatchException e) {
            System.err.println("Invalid input. Please enter a number for the menu choice.");
        }
    }
}
