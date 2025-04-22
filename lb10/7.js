function generatePassword(length) {
  
    const lowercase = 'abcdefghijklmnopqrstuvwxyz';
    const uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const numbers = '0123456789';
    const specials = '!@#$%^&*()_+-=[]{}|;:,.<>?';
  
    const password = [
      lowercase[Math.floor(Math.random() * lowercase.length)],
      uppercase[Math.floor(Math.random() * uppercase.length)],
      numbers[Math.floor(Math.random() * numbers.length)],
      specials[Math.floor(Math.random() * specials.length)]
    ];
  
    const allChars = lowercase + uppercase + numbers + specials;
    for (let i = 4; i < length; i++) {
      password.push(allChars[Math.floor(Math.random() * allChars.length)]);
    }
  
    for (let i = password.length - 1; i > 0; i--) {
      const j = Math.floor(Math.random() * (i + 1));
      [password[i], password[j]] = [password[j], password[i]];
    }
  
    return password.join('');
}
console.log(generatePassword(8));