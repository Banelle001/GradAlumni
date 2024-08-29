    <!-- Modal -->
    <div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="postModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                  <h5 class="modal-title" id="postModalLabel">Create New Post</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                  <form id="postForm" action="../../controller/Alumni/post.php" method="POST">
                    <div class="mb-3">
                      <label for="postTitle" class="form-label">Title</label>
                      <input type="text" class="form-control" id="postTitle" placeholder="Enter title" required>
                    </div>
                    <div class="mb-3">
                      <label for="postContent" class="form-label">Content</label>
                      <textarea class="form-control" id="postContent" rows="4" placeholder="Enter content" required></textarea>
                    </div>
                    <div class="mb-3">
                      <label for="postCategory" class="form-label">Category</label>
                      <select class="form-control" id="postCategory" required>
                        <option value="" disabled selected>Select category</option>
                        <option value="Tech">Tech</option>
                        <option value="Health">Health</option>
                        <option value="Finance">Finance</option>
                        <option value="Education">Education</option>
                        <option value="Art">Arts</option>
                      </select>
                    </div>
                  </form>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn">Post</button>
                </div>
              </div>
            </div>
          </div>
      </div>