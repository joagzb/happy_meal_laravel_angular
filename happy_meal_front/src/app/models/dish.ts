export interface Dish {
  name: string;
  ingredients: Ingredient[];
}

export interface Ingredient {
  id: number;
  name: string;
  quantity: number;
}
