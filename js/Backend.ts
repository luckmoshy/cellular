/**
 * Provides a simple interface to send requests to the backend.
 */
export default class Backend {
  private url: string;
  private readonly csrfToken: string | null;

  constructor(url: string, csrfToken: string | null = null) {
    this.url = url;
    this.csrfToken = csrfToken;
  }

  /**
   * Sends a request to the backend,
   * @param el
   * @param payload
   */
  sendRequest(snapshot, payload) {
    return fetch(this.url, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        snapshot,
        ...payload,
      }),
    }).then((res) => res.json());
  }

  /**
   * @todo refactor this out of the class as it has nothing to do with the backend
   * @param el
   */
  updateModelInputs(el) {
    const data = el.__cellular.data;

    el.querySelectorAll("[cell\\:model]").forEach((i) => {
      const property = i.getAttribute("cell:model");
      i.value = data[property];
    });
  }
}
