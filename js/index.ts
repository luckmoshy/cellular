import CellCollection from "./CellCollection";

/**
 * The main controller that manages all the cells.
 */
export default class LiveController {
  private cells: CellCollection;

  constructor() {
    this.cells = new CellCollection();
  }

  /**
   * Initialize all the cells on the page during the first load.
   */
  initialize() {
    // Find all the cells on the page and initialize them.
    document.querySelectorAll("[cell\\:snapshot]").forEach((el: Element) => {
      const cell = this.cells.addCell(
        el,
        JSON.parse(el.getAttribute("cell:snapshot") || "")
      );

      cell.initCellClick();
      cell.updateModelInputs();
      cell.initCellModel();
    });
  }
}

// On page load, ensure all cells have their initial state.
const cellular = new LiveController();
cellular.initialize();
