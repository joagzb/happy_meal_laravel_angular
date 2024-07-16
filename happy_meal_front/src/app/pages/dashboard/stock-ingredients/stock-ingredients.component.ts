import {Component, OnInit} from '@angular/core';
import {Ingredient} from '../../../models/dish.js';
import {FormsModule} from '@angular/forms';
import {map, Observable} from 'rxjs';
import {StockService} from '../../../services/stock-service.service.js';
import {CommonModule} from '@angular/common';
import {getFoodWithEmoji} from '../../../helpers/food.helper.js';

@Component({
  selector: 'app-stock-ingredients',
  standalone: true,
  imports: [FormsModule, CommonModule],
  templateUrl: './stock-ingredients.component.html',
  styleUrl: './stock-ingredients.component.css',
})
export class StockIngredientsComponent implements OnInit {
  searchInputValue = '';
  ingredients$: Observable<Ingredient[]> | undefined;
  filteredIngredients$: Observable<Ingredient[]> | undefined;

  constructor(private stockService: StockService) {}

  ngOnInit(): void {
    this.ingredients$ = this.stockService.getIngredientStock();
    this.filterIngredients();
  }

  filterIngredients() {
    if (!this.ingredients$) {
      return;
    }
    this.filteredIngredients$ = this.ingredients$.pipe(
      map(ingredients => ingredients.filter(ingredient => ingredient.name.toLowerCase().includes(this.searchInputValue.toLowerCase()))),
      map(ingredients => ingredients.map(ingredient => ({...ingredient, name: getFoodWithEmoji(ingredient.name)}))),
    );
  }
}
