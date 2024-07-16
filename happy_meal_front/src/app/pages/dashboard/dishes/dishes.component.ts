import {Component, OnInit} from '@angular/core';
import {Dish} from '../../../models/dish.js';
import {Observable} from 'rxjs';
import {KitchenService} from '../../../services/kitchen-service.service.js';
import {CommonModule} from '@angular/common';
import {getFoodWithEmoji} from '../../../helpers/food.helper.js';

@Component({
  selector: 'app-dishes',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './dishes.component.html',
  styleUrl: './dishes.component.css',
})
export class DishesComponent implements OnInit {
  selectedDish: Dish | undefined;
  dishes$: Observable<Dish[]> | undefined;

  constructor (private kitchenService: KitchenService) {}

  ngOnInit(): void {
    this.dishes$ = this.kitchenService.getDishes();
  }

  openDetailDishModal(dish: Dish) {
    this.selectedDish = dish;
    this.decorateDish();
  }

  closeDetailDishModal() {
    this.selectedDish = undefined;
  }

  private decorateDish() {
    if (this.selectedDish) {
      this.selectedDish.ingredients.map((ingredient) => {
        ingredient.name = getFoodWithEmoji(ingredient.name);
      });
    }
  }
}
