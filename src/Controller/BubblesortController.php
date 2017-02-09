<?php

namespace Drupal\bubblesort\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Controller for bubblesort routes.
 */
class BubblesortController extends ControllerBase {

  /**
   * Returns JSON data of form inputs.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   A JSON response containing the sorted numbers.
   */
  public function bubblesort_json($data) {
    if (empty($data)) {
      $numbers = numbers_generate();
    }
    else {
      $data_parts = explode('&', $data);
      foreach($data_parts as $part) {
        $fields[] = explode('=', $part);
      }
      // Loop through each field and grab values.
      foreach($fields as $field) {
        if (!empty($field[1])) {
          switch ($field[0]) {
            case 'numbers_total':
              $total = $field[1];;
              break;
            case 'number1':
              $range1 = $field[1];
              break;
            case 'number2':
              $range2 = $field[1];
              break;
          }
        }
      }
      // Generate the random numbers within range.
      $numbers = $this->numbers_generate($total, $range1, $range2, false);
    }
    // Return a response as JSON.
    return new JsonResponse($numbers);
  }

  /**
   * Generates random numbers between delimiters.
   *
   * @param integer $total
   *   The total number of bars.
   * @param integer $range1
   *   The starting number.
   * @param integer $range2
   *   The ending number.
   * @return array
   */
  private function numbers_generate($total = 10, $range1 = 1, $range2 = 100, $sort = FALSE) {
    $numbers = range($range1, $range2);
    shuffle($numbers);
    $numbers=array_slice($numbers, 0, $total);
    if ($sort) {
      rsort($numbers);
    }
    return $numbers;
  }
}
