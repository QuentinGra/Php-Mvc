document.querySelectorAll("input[data-switch-article-id]").forEach((input) => {
  input.addEventListener("change", async (e) => {
    const id = e.target.dataset.switchArticleId;

    const response = await fetch(`/admin/articles/${id}/switch`);

    console.log(await response.json());
  });
});
