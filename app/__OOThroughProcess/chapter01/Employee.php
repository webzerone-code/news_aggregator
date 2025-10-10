<?php

namespace App\__OOThroughProcess\chapter01;

class Employee
{
    private string $socialSecurityNumber;
    private bool $gender;
    private string $dateOfBirth;

    public function getSocialSecurityNumber():string
    {
        return $this->socialSecurityNumber;
    }

    public function getGender():bool
    {
        return $this->gender;
    }
    public function getDateOfBirth():string
    {
        return $this->dateOfBirth;
    }

    public function setSocialSecurityNumber(string $socialSecurityNumber): void
    {
        $this->socialSecurityNumber = $socialSecurityNumber;
    }

    public function setGender(bool $gender): void
    {
        $this->gender = $gender;
    }

    public function setDateOfBirth(string $dateOfBirth): void
    {
        $this->dateOfBirth = $dateOfBirth;
    }

}
