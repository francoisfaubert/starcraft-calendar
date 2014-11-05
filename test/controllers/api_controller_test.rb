require 'test_helper'

class ApiControllerTest < ActionController::TestCase
  test "should get schedule" do
    get :schedule
    assert_response :success
  end

  test "should get scores" do
    get :scores
    assert_response :success
  end

end
