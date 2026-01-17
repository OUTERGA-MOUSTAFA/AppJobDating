<?php
namespace App\app\core;
use App\app\core\Database;
class Validator
{
    private $errors = [];
    private $data = [];

    /**
     * Valide les données selon les règles
     */
    public function validate(array $data, array $rules): bool
    {
        $this->data = $data;
        $this->errors = [];

        foreach ($rules as $field => $ruleString) {
            $rulesArray = explode('|', $ruleString);
            $value = $data[$field] ?? null;

            foreach ($rulesArray as $rule) {
                $this->applyRule($field, $value, $rule);
            }
        }

        return empty($this->errors);
    }

    /**
     * Applique une règle de validation
     */
    private function applyRule(string $field, $value, string $rule): void
    {
        // Parse rule avec paramètres (ex: min:5)
        $parts = explode(':', $rule);
        $ruleName = $parts[0];
        $parameter = $parts[1] ?? null;

        switch ($ruleName) {
            case 'required':
                if (empty($value) && $value !== '0') {
                    $this->addError($field, "Le champ {$field} est requis");
                }
                break;

            case 'email':
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($field, "Le champ {$field} doit être un email valide");
                }
                break;

            case 'min':
                if (strlen($value) < (int)$parameter) {
                    $this->addError($field, "Le champ {$field} doit contenir au moins {$parameter} caractères");
                }
                break;

            case 'max':
                if (strlen($value) > (int)$parameter) {
                    $this->addError($field, "Le champ {$field} ne doit pas dépasser {$parameter} caractères");
                }
                break;

            case 'numeric':
                if (!is_numeric($value)) {
                    $this->addError($field, "Le champ {$field} doit être numérique");
                }
                break;

            case 'alpha':
                if (!ctype_alpha($value)) {
                    $this->addError($field, "Le champ {$field} ne doit contenir que des lettres");
                }
                break;

            case 'alphanumeric':
                if (!ctype_alnum($value)) {
                    $this->addError($field, "Le champ {$field} ne doit contenir que des lettres et chiffres");
                }
                break;

            case 'confirmed':
                $confirmField = $field . '_confirmation';
                if ($value !== ($this->data[$confirmField] ?? null)) {
                    $this->addError($field, "La confirmation ne correspond pas");
                }
                break;

            case 'unique':
                // Format: unique:table,column
                if ($parameter) {
                    list($table, $column) = explode(',', $parameter);
                    if ($this->checkUnique($table, $column, $value)) {
                        $this->addError($field, "Cette valeur existe déjà");
                    }
                }
                break;

            case 'url':
                if (!filter_var($value, FILTER_VALIDATE_URL)) {
                    $this->addError($field, "Le champ {$field} doit être une URL valide");
                }
                break;
        }
    }

    /**
     * Ajoute une erreur
     */
    private function addError(string $field, string $message): void
    {
        $this->errors[$field][] = $message;
    }

    /**
     * Récupère toutes les erreurs
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * Récupère les erreurs d'un champ spécifique
     */
    public function error(string $field): ?array
    {
        return $this->errors[$field] ?? null;
    }

    /**
     * Vérifie l'unicité en base de données
     */
    private function checkUnique(string $table, string $column, $value): bool
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT COUNT(*) FROM {$table} WHERE {$column} = ?");
            $stmt->execute([$value]);
            return $stmt->fetchColumn() > 0;
        } catch (\Exception $e) {
            return false;
        }
    }

}