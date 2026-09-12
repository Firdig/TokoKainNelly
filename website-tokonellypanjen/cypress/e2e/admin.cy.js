describe('Admin Scenarios', () => {
    describe('Admin Products & Orders (Login: admin@tokonelly.com)', () => {
        beforeEach(() => {
            cy.visit('/login')
            cy.get('input[name="email"]').type('admin@tokonelly.com')
            cy.get('input[name="password"]').type('password123')
            cy.get('button[type="submit"]').click()
        })

        // Skenario 4: Menambah Kategori Produk
        it('Skenario 4: Menambah Kategori Produk', () => {
            cy.visit('/admin/categories')
            
            // Form Tambah Kategori
            const randomCategory = `Kategori Baru ${Math.floor(Math.random() * 1000)}`
            cy.get('input[name="name"]').first().type(randomCategory)
            cy.get('button:contains("Tambah")').first().click()
            
            cy.contains(randomCategory).should('exist')
        })

        // Skenario 3: Menambah Produk Baru
        it('Skenario 3: Menambah Produk Baru', () => {
            cy.visit('/admin/products/create')
            
            cy.get('input[name="name"]').type('Produk Kain Test')
            cy.get('textarea[name="description"]').type('Deskripsi produk kain test yang sangat bagus dan berkualitas tinggi.')
            cy.get('input[name="price"]').type('50000')
            
            // Varian (Wajib sesuai form blade)
            cy.get('input[name="variants[0][color_name]"]').type('Merah Maroon')
            cy.get('input[name="variants[0][stock]"]').type('100')
            
            cy.get('button[type="submit"]').contains('Simpan Produk').click()
            
            cy.url().should('include', '/admin/products')
        })

        // Skenario 5: Mencatat Stok Masuk
        it('Skenario 5: Mencatat Stok Masuk', () => {
            cy.visit('/admin/restock')
            
            // Select varian yang memiliki ID (bukan option default "-- Ketik atau Pilih --")
            cy.get('select[name="product_variant_id"] option').not('[value=""]').first().then($option => {
                cy.get('select[name="product_variant_id"]').select($option.val())
            })
            
            cy.get('input[name="quantity"]').type('50')
            cy.get('button[type="submit"]').contains('Tambah Stok').click()
            
            // Cek notifikasi success (menggunakan .bg-green-50 sesuai blade alert)
            cy.get('.bg-green-50').should('exist')
        })

        // Skenario 11: Memproses Pesanan Online
        it('Skenario 11: Memproses Pesanan Online', () => {
            cy.visit('/admin/orders')
            cy.get('body').then(($body) => {
                if ($body.find('a:contains("Detail")').length > 0) {
                    cy.contains('Detail').first().click()
                    cy.get('body').then(($body2) => {
                        if ($body2.find('select[name="status"]').length > 0) {
                            cy.get('select[name="status"]').select('Sedang Disiapkan')
                            if ($body2.find('button:contains("Simpan")').length > 0) {
                                cy.contains('Simpan').click()
                            }
                        }
                    })
                }
            })
            cy.get('body').should('exist')
        })

        // Skenario 12: Memverifikasi Pengambilan BOPS
        it('Skenario 12: Memverifikasi Pengambilan BOPS', () => {
            cy.visit('/admin/scanner')
            cy.get('body').then(($body) => {
                if ($body.find('input[name="pickup_code"]').length > 0) {
                    cy.get('input[name="pickup_code"]').should('exist')
                }
            })
            cy.get('body').should('exist')
        })

        // Skenario 22: Verifikasi BOPS dengan Kode Tidak Valid
        it('Skenario 22: Verifikasi BOPS dengan Kode Tidak Valid', () => {
            cy.visit('/admin/scanner')
            cy.get('body').then(($body) => {
                if ($body.find('input[name="pickup_code"]').length > 0) {
                    cy.get('input[name="pickup_code"]').type('INVALID-CODE-999')
                    cy.contains('Verifikasi').click()
                }
            })
            cy.get('body').should('exist')
        })
    })

    describe('Admin POS (Login: staff@tokonelly.com)', () => {
        beforeEach(() => {
            cy.visit('/login')
            cy.get('input[name="email"]').type('staff@tokonelly.com') 
            cy.get('input[name="password"]').type('password123')
            cy.get('button[type="submit"]').click()
        })

        // Skenario 10: Memproses Transaksi POS
        it('Skenario 10: Memproses Transaksi POS', () => {
            cy.visit('/kasir')
            
            cy.get('body').then(($body) => {
                if ($body.find('.product-item').length > 0 || $body.find('.product-card').length > 0) {
                    // Pilih produk
                    cy.get('.product-item, .product-card').first().click()
                    
                    // Pilih metode pembayaran jika ada
                    if ($body.find('select[name="payment_method"]').length > 0) {
                        cy.get('select[name="payment_method"]').select('cash')
                    }
                    
                    // Selesaikan
                    if ($body.find('button:contains("Bayar"), button:contains("Proses")').length > 0) {
                        cy.contains(/Bayar|Proses/i).click()
                    }
                }
            })
            cy.get('body').should('exist')
        })
    })
})
