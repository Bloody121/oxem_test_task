<?php

/**
 * Интерфейс модели животного.
 */
interface AnimalInterface
{
    public function nameAnimal(): string;
    public function nameProduct(): string;
    public function giveProduct(): int;
}

/**
 * Базовый класс для животных, на случай если каждому
 * животному потребуется ввести общую функцию.
 */
class BaseAnimal implements AnimalInterface
{
    public function nameAnimal(): string {
        return "";
    }
    public function nameProduct(): string {
        return "";
    }
    public function giveProduct(): int {
        return 0;
    }
}

/**
 * Класс коровы.
 */
class Cow extends BaseAnimal
{
    public function nameAnimal(): string
    {
        return 'Cow';
    }
    public function nameProduct(): string
    {
        return 'milk l.';
    }
    public function giveProduct(): int
    {
        return rand(8,12);
    }
}

/**
 * Класс курицы.
 */
class Chicken extends BaseAnimal
{
    public function nameAnimal(): string
    {
        return 'Chicken';
    }

    public function nameProduct(): string
    {
        return 'egg pc.';
    }
    public function giveProduct(): int
    {
        return rand(0,1);
    }
}

class Farm 
{
    private $stable = [];
    private $products;

    public function __construct()
    {
        $this->products = array();
    }

    /**
     * Добавляет новое животное в хлев.
     * 
     * @param Animal $animal
     */
    public function addNew(BaseAnimal $animal)
    {
        $name = $animal->nameAnimal();

        if (key_exists($name, $this->stable)){
            array_push($this->stable[$name], $animal);
        }
        else {
            $this->stable[$name] = array($animal);
        }
    }

    /**
     * Собирает продукты у зарегистрированных животных.
     */
    public function collectProducts()
    {
        foreach(array_keys($this->stable) as $key){
            foreach ($this->stable[$key] as $animal){   
                if (array_key_exists($animal->nameProduct(), $this->products)){
                    $this->products[$animal->nameProduct()] += $animal->giveProduct();
                }
                else {
                    $this->products[$animal->nameProduct()] = $animal->giveProduct();
                }
            }
        }
    }

    /**
     * Выводит количество собранных продуктов.
     */
    public function getProducts()
    {
        foreach (array_keys($this->products) as $key)
        {
            echo $this->products[$key]." $key\n";
        }
    }

    /**
     * Выводит количество зарегистрированных животных.
     */
    public function countAnimals()
    {
        foreach(array_keys($this->stable) as $key)
        {
            echo "$key`s = ".count($this->stable[$key])."\n";
        }
    }

}

$farm = new Farm;

// Добавляем коров
for ($i=0; $i < 10; $i++)
{
    $farm->addNew(new Cow);
}

// Добавляем куриц
for ($i=0; $i < 20; $i++)
{
    $farm->addNew(new Chicken);
}

echo $farm->countAnimals();

// Собираем продукты
for ($i=0; $i < 7; $i++)
{
    $farm->collectProducts();
}

// Получаем количество собранных продуктов за 7 дней
echo $farm->getProducts();

// Добавляем еще 5 кур
for ($i=0; $i < 5; $i++)
{
    $farm->addNew(new Chicken);
}

// И одну корову
$farm->addNew(new Cow);

echo $farm->countAnimals();

// Собираем продукты
for ($i=0; $i < 7; $i++)
{
    $farm->collectProducts();
}

echo $farm->getProducts();




