<?php

/* UPS Modules */
use Rawilk\Ups\Entity\Address\Address;
use Rawilk\Ups\Apis\AddressValidation\AddressValidation;

/* UPS Shipment */
use Rawilk\Ups\Entity\Shipment\Shipment;
use Rawilk\Ups\Entity\Shipment\Shipper;
use Rawilk\Ups\Entity\Shipment\ShipTo;
use Rawilk\Ups\Entity\Shipment\ShipFrom;
use Rawilk\Ups\Entity\Shipment\Package;
use Rawilk\Ups\Entity\Shipment\PackagingType;
use Rawilk\Ups\Entity\Shipment\ReferenceNumber;
use Rawilk\Ups\Entity\Shipment\PackagingResult;
use Rawilk\Ups\Entity\Shipment\PackageWeight;
use Rawilk\Ups\Apis\Shipping\ShipConfirm;
use Rawilk\Ups\Apis\Shipping\ShipAccept;

/* UPS Rate */
use Ups\Rate;
use Ups\Entity\RateRequest as RateRequest;
use Ups\Entity\Shipment as UPSShipment;
use Ups\Entity\Address as UPSAddress;
use Ups\Entity\ShipFrom as UPSShipFrom;
use Ups\Entity\Package as UPSPackage;
use Ups\Entity\PackagingType as UPSPackagingType;
use Ups\Entity\UnitOfMeasurement as UPSUnitOfMeasurement;
use Ups\Entity\Dimensions as UPSDimensions;

/* UPS Payment */
use Rawilk\Ups\Entity\Payment\PaymentInformation;

/* UPS Label */
use Rawilk\Ups\Entity\Shipment\Label\LabelSpecification;

/* Regular Laravel */
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Exception;
use Request;

class ShipmentService
{   
    
}