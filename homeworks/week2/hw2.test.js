var alphaSwap = require('./hw2')

describe("hw2", function() {
  it("should return correct answer when str = nick", function() {
    expect(alphaSwap('nick')).toBe('NICK')
  })
  it("should return correct answer when str = nikeeeeeeee", function() {
    expect(alphaSwap('nikeeeeeeee')).toBe('NIKEEEEEEEE')
  })
  it("should return correct answer when str = enterSKY", function() {
    expect(alphaSwap('enterSKY')).toBe('ENTERsky')
  })
})