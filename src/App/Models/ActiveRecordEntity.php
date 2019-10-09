<?php

namespace App\Models;

use App\Services\Db;

abstract class ActiveRecordEntity
{
    /** @var int */
    protected $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    // Сеттер для свойств объекта, которые не совпали с имена столбцов БД
    public function __set(string $name, $value)
    {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }

    private function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }


    // Метод обращения в БД для получения всех статей на главную

    /**
     * @return static[]
     */
    public static function findAll(): array
    {
        $db = Db::getInstance();
        return $db->query('SELECT * FROM `' . static::getTableName() . '`;', [], static::class);
    }

    // Метод обращения в БД для получения ведомости по имени
    public static function findByName(string $query): ?array
    {
        $db = Db::getInstance();
        $entities = $db->query('SELECT * FROM `' . static::getTableName() . '` WHERE name = :name;', [':name' => $query], static::class);
        return $entities ? $entities : null;
    }

    // Метод обращения в БД для получения конкретной статьи
    /**
     * @param int $id
     * @return static|null
     */
    public static function getById(int $id): ?self
    {
        $db = Db::getInstance();
        $entities = $db->query('SELECT * FROM `' . static::getTableName() . '` WHERE id = :id;', [':id' => $id], static::class);
        return $entities ? $entities[0] : null;
    }

    // Экшен, который опеределяет что нужно сделать с данными в БД (обновить или добавить)
    public function save(): void
    {
        $mappedProperties = $this->mapPropertiesToDbFormat();
        if ($this->id !== null) {
            $this->update($mappedProperties);
        } else {
            $this->insert($mappedProperties);
        }
    }

    // Экшен для обновления данных в БД
    private function update(array $mappedProperties): void
    {
        $columns2params = [];
        $params2values = [];
        $index = 1;
        foreach ($mappedProperties as $column => $value) {
            $param = ':param' . $index; // :param1
            $columns2params[] = $column . ' = ' . $param; // column1 = :param1
            $params2values[':param' . $index] = $value; // [:param1 => value1]
            $index++;
        }
        $sql = 'UPDATE ' . static::getTableName() . ' SET ' . implode(', ', $columns2params) . ' WHERE id = ' . $this->id;
        $db = Db::getInstance();
        $db->query($sql, $params2values, static::class);
    }

    // Экшен для добавления данных в БД
    private function insert(array $mappedProperties): void
    {
        $filteredProperties = array_filter($mappedProperties);

        $columns = [];
        $paramsNames = [];
        $params2values = [];
        foreach ($filteredProperties as $columnName => $value) {
            $columns[] = '`' . $columnName . '`'; // `column`
            $paramName = ':' . $columnName; // :param1
            $paramsNames[] = $paramName;
            $params2values[$paramName] = $value; // [:param1 = value1], [:param2 = value2] ...
        }

        $columnsViaSemicolon = implode(', ', $columns);
        $paramsNamesViaSemicolon = implode(', ', $paramsNames);

        $sql = 'INSERT INTO ' . static::getTableName() . ' (' . $columnsViaSemicolon . ') VALUES (' . $paramsNamesViaSemicolon . ');';
        $db = Db::getInstance();
        $db->query($sql, $params2values, static::class);
        $this->id = $db->getLastInsertId();
        $this->refresh();
    }

    // Экшен для обновления полей объекта значениями из БД
    private function refresh(): void
    {
        $objectFromDb = static::getById($this->id);
        $reflector = new \ReflectionObject($objectFromDb);
        $properties = $reflector->getProperties();

        foreach ($properties as $property) {
            $property->setAccessible(true);
            $propertyName = $property->getName();
            $this->$propertyName = $property->getValue($objectFromDb);
        }
    }

    // Экшен для удаления данных из БД
    public function delete(): void
    {
        $db = Db::getInstance();
        $db->query('DELETE FROM `' . static::getTableName() . '` WHERE id = :id', [':id' => $this->id]);
        $this->id = null;
    }


    // Функция, которая приводит имена свойст к "under_score" стилю
    private function mapPropertiesToDbFormat(): array
    {
        $reflector = new \ReflectionObject($this);
        $properties = $reflector->getProperties();

        $mappedProperties = [];
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $propertyNameAsUnderscore = $this->camelCaseToUnderscore($propertyName);
            $mappedProperties[$propertyNameAsUnderscore] = $this->$propertyName;
        }

        return $mappedProperties;

    }

    // Непосредственно сама функция превращения свойств в стиль написания "under_score"
    private function camelCaseToUnderscore(string $source): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));   /*[A-Z] - берём большие буквы
                                                                                               (?<!^) - то, что в начале строки не берем (кроме тех, что стоят в середине строки)
                                                                                               _$0 - это знак подчеркивания, за которым следует нулевое совпадение в регулярке (нулевое - это вся строка, попавшая под регулярку. В нашем случае - это одна большая буква). Таким образом, с помощью preg_replace, мы заменяем все большие буквы A - Z на _A - _Z. А затем с помощью strtolower приводим всю строку к нижнему регистру.*/
    }

    // Абстрактный метод получения имени таблицы БД, необходимый для sql запросов (вызывается в конерктном классе)
    abstract protected static function getTableName(): string;
}
