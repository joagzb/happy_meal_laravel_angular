import {Component, OnDestroy, OnInit} from '@angular/core';
import {Observable, Subscription} from 'rxjs';
import {Purchase} from '../../../models/purchse.js';
import {StockService} from '../../../services/stock-service.service.js';
import {CommonModule} from '@angular/common';

@Component({
  selector: 'app-stock-purchases',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './stock-purchases.component.html',
  styleUrl: './stock-purchases.component.css',
})
export class StockPurchasesComponent implements OnInit, OnDestroy {
  private subscription: Subscription = new Subscription();
  purchases$: Observable<Purchase[]> | undefined;
  paginatedPurchases: Purchase[] = [];
  currentPage = 1;
  itemsPerPage = 10;
  totalPages = 0;
  sortOrder: 'asc' | 'desc' = 'asc';
  sortField: 'ingredient' | 'quantityPurchased' | 'date' = 'date';

  constructor(private stockService: StockService) {}

  ngOnInit() {
    this.purchases$ = this.stockService.getPurchaseHistory();

    const purchasesSubscription = this.purchases$.subscribe(purchases => {
      this._setTotalPages(purchases);
      this._paginateItems(purchases);
    });

    this.subscription.add(purchasesSubscription);
  }

  ngOnDestroy() {
    this.subscription.unsubscribe();
  }

  private _setTotalPages(purchases: Purchase[]) {
    this.totalPages = Math.ceil(purchases.length / this.itemsPerPage);
  }

  private _paginateItems(purchases: Purchase[]) {
    this.paginatedPurchases = purchases.sort((a, b) => this._comparator(a, b)).slice((this.currentPage - 1) * this.itemsPerPage, this.currentPage * this.itemsPerPage);
  }

  private _comparator(a: Purchase, b: Purchase): number {
    const fieldA = a[this.sortField];
    const fieldB = b[this.sortField];

    if (fieldA < fieldB) return this.sortOrder === 'asc' ? -1 : 1;
    if (fieldA > fieldB) return this.sortOrder === 'asc' ? 1 : -1;
    return 0;
  }

  sort(field: 'ingredient' | 'quantityPurchased' | 'date') {
    this.sortField = field;
    this.sortOrder = this.sortOrder === 'asc' ? 'desc' : 'asc';
    this.updatePagination();
  }

  nextPage() {
    if (this.currentPage < this.totalPages) {
      this.currentPage++;
      this.updatePagination();
    }
  }

  previousPage() {
    if (this.currentPage > 1) {
      this.currentPage--;
      this.updatePagination();
    }
  }

  updatePagination() {
    if (this.purchases$) {
      this.purchases$.subscribe(orders => {
        this._paginateItems(orders);
      });
    }
  }

  printSortOrderIcon() {
    return this.sortOrder === 'asc' ? ' ▲' : ' ▼';
  }
}
