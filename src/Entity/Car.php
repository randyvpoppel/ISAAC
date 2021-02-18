<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @final
 *
 * @ORM\Entity()
 */
class Car
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=255)
     */
    private string $numberPlate;

    /**
     * @ORM\ManyToOne(targetEntity="Model")
     * @ORM\JoinColumn(name="model_id", referencedColumnName="id")
     */
    private Model $model;

    /**
     * @ORM\ManyToOne(targetEntity="Customer")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     */
    private Customer $customer;

    public function __construct(string $numberPlate, Model $model, Customer $customer)
    {
        $this->numberPlate = $numberPlate;
        $this->model = $model;
        $this->customer = $customer;
    }

    public function getNumberPlate(): string
    {
        return $this->numberPlate;
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }
}
