# =========| EIP |=========

resource "aws_eip" "eip-for-nat-gateway-1" {
  vpc    = true

  tags   = {
    Name = "EIP 1"
  }
}

resource "aws_eip" "eip-for-nat-gateway-2" {
  vpc    = true

  tags   = {
    Name = "EIP 2"
  }
}