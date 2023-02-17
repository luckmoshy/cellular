import Backend from "./Backend";
import { decodeHtml } from "./helpers/string_helper";

/**
 * Represents a single Live Cell and provides methods
 * for working with it.
 */
export default class Cell {
  readonly element: HTMLElement;
  private readonly backend: Backend;
  snapshot: any;
  private updatedProperties = [];

  /**
   * @param element     The root HTML element of the cell
   * @param snapshot    The snapshot object for the cell
   * @param backend     The backend instance for updating the cell
   */
  constructor(element, snapshot, backend) {
    this.element = element;
    this.snapshot = snapshot;
    this.backend = backend;
  }

  /**
   * @returns The name of the cell.
   */
  name(): string {
    return this.snapshot.name;
  }

  /**
   * Initialiazes the cell click event listener.
   */
  initCellClick(): void {
    this.element.addEventListener("click", (e: any) => {
      e.preventDefault();
      if (!e.target?.hasAttribute("cell:click")) {
        return;
      }

      let method = e.target?.getAttribute("cell:click");
      this.#sendRequest({
        method: method,
        updateProperties: { ...this.updatedProperties },
      });

      this.updatedProperties = [];
    });
  }

  /**
   * Initializes the model inputs for the cell.
   */
  initCellModel(): void {
    // Listen for changes
    this.element.addEventListener("input", (e: any) => {
      e.preventDefault();
      if (!e.target?.hasAttribute("cell:model")) {
        return;
      }

      const property = e.target?.getAttribute("cell:model");
      const value = e.target?.value;

      // Add the property/value to the updatedProperties array
      // so we can send it to the server.
      this.updatedProperties[property] = value;
    });
  }

  /**
   * Sends the request to the server with any updates.
   * @param payload
   */
  #sendRequest(payload: object): void {
    this.backend.sendRequest(this.snapshot, payload).then((response) => {
      const { html, snapshot } = response;
      this.snapshot = JSON.parse(decodeHtml(snapshot));

      Alpine.morph(this.element.firstElementChild, html);

      this.updateModelInputs();
    });
  }

  /**
   * Private method to update the model inputs of any
   * cells with watched models.
   */
  updateModelInputs(): void {
    const data = this.snapshot.data;

    this.element.querySelectorAll("[cell\\:model]").forEach((i) => {
      const property = i.getAttribute("cell:model");
      i.value = data[property];
    });
  }
}
