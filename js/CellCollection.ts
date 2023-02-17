import Backend from "./Backend";
import Cell from "./Cell";
import { Snapshot } from "./types";

/**
 * Manages a collection of cells.
 */
export default class CellCollection {
  private readonly backend: Backend;
  private cells: Cell[];

  constructor() {
    this.backend = new Backend("/_cellular");
    this.cells = [];
  }

  /**
   * Adds a new cell to the collection and returns it.
   */
  addCell(el: Element, snapshot: Snapshot): Cell {
    const cell = new Cell(el, snapshot, this.backend);
    this.cells.push(cell);

    return cell;
  }

  /**
   * Remove the cell from the collection, rmeove the event listeners,
   * and remove the cell from the DOM.
   */
  removeCell(el: Element): void {
    const cell = this.getCell(el);
    if (cell) {
      el.removeEventListener("click", cell.initCellClick);
    }

    this.cells = this.cells.filter((cell) => cell.element !== el);
    el.remove();
  }

  /**
   * Returns the cell associated with the given element.
   */
  getCell(el: Element): Cell | undefined {
    return this.cells.find((cell) => cell.element === el);
  }

  /**
   * Returns all the cells in the collection.
   */
  getCells(): Cell[] {
    return this.cells;
  }
}
