import {Routes} from '@angular/router';
import {routesSchema} from './config/route.schema.js';
import {StockPurchasesComponent} from './pages/dashboard/stock-purchases/stock-purchases.component.js';
import {StockIngredientsComponent} from './pages/dashboard/stock-ingredients/stock-ingredients.component.js';
import {DishesComponent} from './pages/dashboard/dishes/dishes.component.js';
import {OrderHistoryComponent} from './pages/dashboard/order-history/order-history.component.js';
import {OrdersComponent} from './pages/dashboard/orders/orders.component.js';
import {PageNotFoundComponent} from './pages/page-not-found/page-not-found.component.js';

export const routes: Routes = [
  {path: '', redirectTo: routesSchema.orders.list, pathMatch: 'full'},
  {path: 'index', redirectTo: routesSchema.orders.list, pathMatch: 'full'},
  {path: 'home', redirectTo: routesSchema.orders.list, pathMatch: 'full'},
  {path: routesSchema.orders.list, component: OrdersComponent},
  {path: routesSchema.orders.history, component: OrderHistoryComponent},
  {path: routesSchema.dishes, component: DishesComponent},
  {path: routesSchema.stock.ingredients, component: StockIngredientsComponent},
  {path: routesSchema.stock.purchases, component: StockPurchasesComponent},
  {path: '**', component: PageNotFoundComponent},
];
