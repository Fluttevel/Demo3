# =========| LISTENERS |=========

resource "aws_alb_listener" "http" {
  load_balancer_arn  = aws_lb.demo.arn
  port               = 80
  protocol           = "HTTP"

  # Default return empty page with code 404
  default_action {
    type = "fixed-response"

    fixed_response {
      content_type = "text/plain"
      message_body = "404: page not found"
      status_code  = 404
    }
  }
}